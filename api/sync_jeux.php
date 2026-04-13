<?php
/* ============================================================
   SYNC_JEUX.PHP — Peuple la table `jeu` depuis l'API IGDB
   Récupère : titre, genre, dev, cover, hero, screenshots,
              trailer YouTube, rating, date, description.
   À lancer via : http://localhost/NEBULA/api/sync_jeux.php
   ============================================================ */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/igdb.php';

// Débloquer temporairement l'API pour ce script
// (si igdb_query est bloquée dans igdb.php, on passe directement par igdb_curl)
function sync_igdb_query(string $body): array {
    $envPath = dirname(__DIR__) . '/.env.local';
    $env = [];
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos($line, '=') && $line[0] !== '#') {
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v);
        }
    }

    $tokenCache = sys_get_temp_dir() . '/nebula_igdb_token.json';
    $token = '';
    if (file_exists($tokenCache)) {
        $cached = json_decode(file_get_contents($tokenCache), true);
        if ($cached['expires'] > time()) $token = $cached['token'];
    }
    if (!$token) {
        $url  = 'https://id.twitch.tv/oauth2/token'
              . '?client_id=' . $env['IGDB_CLIENT_ID']
              . '&client_secret=' . $env['IGDB_CLIENT_SECRET']
              . '&grant_type=client_credentials';
        $data = json_decode(igdb_curl($url), true);
        $token = $data['access_token'];
        file_put_contents($tokenCache, json_encode(['token' => $token, 'expires' => time() + $data['expires_in']]));
    }

    $res = igdb_curl(
        'https://api.igdb.com/v4/games',
        'POST',
        [
            'Client-ID: ' . $env['IGDB_CLIENT_ID'],
            'Authorization: Bearer ' . $token,
            'Content-Type: text/plain',
        ],
        $body
    );
    $decoded = json_decode($res, true);
    return is_array($decoded) && !isset($decoded['message']) ? $decoded : [];
}

$pdo  = getPDO();
$data = sync_igdb_query("
    fields id,name,genres.name,involved_companies.company.name,
           cover.url,artworks.url,screenshots.url,videos.video_id,
           rating,first_release_date,summary;
    where cover != null & rating > 75;
    sort rating_count desc;
    limit 60;
");

if (empty($data)) {
    echo 'Erreur : l\'API IGDB n\'a retourné aucun résultat. Vérifiez les clés API.';
    exit;
}

$stmt = $pdo->prepare('
    INSERT INTO jeu (igdb_id, titre, genre, developpeur, image_url, hero_url, screenshots, trailer_id, rating, date_sortie, description)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        titre       = VALUES(titre),
        genre       = VALUES(genre),
        developpeur = VALUES(developpeur),
        image_url   = VALUES(image_url),
        hero_url    = VALUES(hero_url),
        screenshots = VALUES(screenshots),
        trailer_id  = VALUES(trailer_id),
        rating      = VALUES(rating),
        date_sortie = VALUES(date_sortie),
        description = VALUES(description)
');

$count = 0;
foreach ($data as $g) {
    if (!is_array($g) || !isset($g['id'], $g['name'])) continue;

    $genres = [];
    foreach ($g['genres'] ?? [] as $genre) $genres[] = $genre['name'];

    $devs = [];
    foreach ($g['involved_companies'] ?? [] as $ic) {
        if (isset($ic['company']['name'])) $devs[] = $ic['company']['name'];
    }

    $imageUrl = isset($g['cover']['url'])
        ? 'https:' . str_replace('t_thumb', 't_1080p', $g['cover']['url'])
        : null;

    // Hero : artwork en priorité, sinon premier screenshot
    $heroUrl = null;
    if (isset($g['artworks'][0]['url'])) {
        $heroUrl = 'https:' . str_replace('t_thumb', 't_1080p', $g['artworks'][0]['url']);
    } elseif (isset($g['screenshots'][0]['url'])) {
        $heroUrl = 'https:' . str_replace('t_thumb', 't_1080p', $g['screenshots'][0]['url']);
    }

    // Screenshots (max 3, format 720p)
    $shots = [];
    foreach (array_slice($g['screenshots'] ?? [], 0, 3) as $s) {
        $shots[] = 'https:' . str_replace('t_thumb', 't_720p', $s['url']);
    }

    $trailerId  = $g['videos'][0]['video_id'] ?? null;
    $rating     = isset($g['rating']) ? round($g['rating'], 2) : null;
    $dateSortie = isset($g['first_release_date']) ? date('Y-m-d', $g['first_release_date']) : null;

    $stmt->execute([
        $g['id'],
        substr($g['name'], 0, 100),
        substr(implode(', ', $genres), 0, 150) ?: null,
        substr(implode(', ', $devs),   0, 255) ?: null,
        $imageUrl,
        $heroUrl,
        $shots ? json_encode($shots) : null,
        $trailerId,
        $rating,
        $dateSortie,
        $g['summary'] ?? null,
    ]);
    $count++;
}

echo "$count jeux synchronisés avec images, hero, screenshots et trailers.";
