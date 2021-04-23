self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('classe-verte').then(function(cache) {
      return cache.addAll([
        '/',
        '/?source=pwa',
        '/android-chrome-192x192.png',
        '/android-chrome-256x256.png',
        '/favicon.ico',
        '/favicon-16x16.png',
        '/favicon-32x32.png',
        '/logo.png',
        '/site.webmanifest'
      ]);
    })
  );
});

self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request).then(function (response) {
      return response || fetch(event.request);
    })
  );
});
