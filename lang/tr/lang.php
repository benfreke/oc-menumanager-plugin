<?php

return [
    'plugin' => [
        'name' => 'Menü Yönetimi',
        'description' => 'Plugin to enable management of menus within October CMS.'
    ],
    'menu' => [
        'name' => 'Menüler',
        'description' => 'Herhangi bir sayfada bir menü görüntüler.',
        'editmenu' => 'Menüleri Düzenle',
        'reordermenu' => 'Menülerin Sıralaması'
    ],
    'misc' => [
        'menu' => 'Menü',
        'newmenu' => 'Yeni Menü',
        'manageorder' => 'Menülerin Sıralarını Düzenle',
        'returntomenus' => 'Menülere Dön'
    ],
    'form' => [
        'create' => 'Menü Oluştur',
        'update' => 'Menü Düzenle',
        'preview' => 'Menüleri Önizle',
        'flashcreate' => 'Menü oluşturuldu',
        'flashupdate' => 'Menü güncellendi',
        'flashdelete' => 'Menü silindi',
        'manage' => 'Menüleri Düzenle'
    ],
    'create' => [
        'menus' => 'Menüler',
        'creating' => 'Menü Oluşturuluyor...',
        'create' => 'Oluştur',
        'createclose' => 'Oluştur ve Kapat',
        'cancel' => 'İptal',
        'or' => 'veya',
        'return' => 'Menü listesine dön',
        'nolink' => 'Link yok'
    ],
    'update' => [
        'saving' => 'Menü Kaydediliyor...',
        'save' => 'Kaydet',
        'saveclose' => 'Kaydet ve Kapat',
        'deleting' => 'Menü Siliniyor...',
        'reallydelete' => 'Menüyü silmek istediğinize emin misiniz?'
    ],
    'modeldata' => [
        'title' => 'Menü Başlığı',
        'enabled' => 'Aktif',
        'url' => 'Bağlı Olan Sayfa',
        'parameters' => 'Parametreler',
        'query' => 'Sorgu parametresi',
        'description' => 'Tanım'
    ],
    'modeldataform' => [
        'title' => 'Menü Başlığı',
        'description' => 'Menü Açıklaması (isteğe bağlı, önerilir)',
        'enabled' => 'Bu linki aktifleştir/pasifleştir',
        'optdisabled' => 'Pasif',
        'optenabled' => 'Aktif',
        'external' => 'Menü yönlendirme tipi',
        'selectmenutype' => '-- Menü Tipini Seçin --',
        'optinternal' => 'Dahili Sayfa',
        'optexternal' => 'Harici Sayfa',
        'internalurl' => 'Link\'in bağlanacağı dosya',
        'internalurlplaceholder' => '-- Linke Bağlanacak Dosya --',
        'externalurl' => 'Harici linki yazın',
        'externalurlcomment' => 'örnek http://medanis.com.tr',
        'linktarget' => 'Link\'in aç:',
        'self' => 'Aynı sayfada',
        'blank' => 'Yeni sayfada',
        'parameters' => 'Ek URL parametreleri (JSON) örnek eğer Link "/:takmaad" a bağlanacaksa',
        'parameterscomment' => '{ "takmaad" : "sayfanin-takma-adi" }',
        'querystr' => 'Sistem harici Link parametreleri (parametrelere otomatik olarak güvenlik sağlanacaktır)',
        'querystrcomment' => 'örnek "parametre1=ilk&amp;parametre2=http://medanis.com.tr"',
        'url' => 'URL'
    ]
];
