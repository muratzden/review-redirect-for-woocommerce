# Review Redirect for WooCommerce - Release Checklist

## Release Bilgisi

- Ürün: Review Redirect for WooCommerce
- Sürüm:
- Release türü: Free / WordPress.org aday sürüm
- Hedef tarih:
- Sorumlu:

## Dokümantasyon

- [ ] `docs/product-spec.md` güncel
- [ ] `docs/ui-spec.md` güncel
- [ ] Release notları hazır
- [ ] WordPress.org readme içeriği güncel
- [ ] Kullanıcıya görünen değişiklikler yazıldı

## Plugin Check

- [ ] Plugin Check çalıştırıldı
- [ ] Kritik hata yok
- [ ] Güvenlik uyarıları incelendi
- [ ] WordPress.org uyumluluk uyarıları incelendi
- [ ] Gerekli düzeltmeler tamamlandı

## Production ZIP

- [ ] Production ZIP oluşturuldu
- [ ] ZIP dosya adı ve sürüm numarası doğru
- [ ] ZIP içinde doğru eklenti klasörü var
- [ ] ZIP açıldığında eklenti WordPress tarafından tanınıyor
- [ ] Geliştirme dosyaları pakete girmedi

## WordPress.org Dosya Temizliği

- [ ] Gereksiz geçici dosyalar temizlendi
- [ ] Test çıktıları pakete dahil edilmedi
- [ ] Geliştirme konfigürasyonları pakete dahil edilmedi
- [ ] Lisans dosyası güncel
- [ ] Readme dosyası WordPress.org standardına uygun
- [ ] Screenshot ve asset kararları kontrol edildi

## UI Desktop/Mobile Test

- [ ] Desktop popup yatay scroll üretmiyor
- [ ] Desktop popup aşırı büyük değil
- [ ] Mobile popup ekran dışına taşmıyor
- [ ] Mobile görünümde butonlar dokunulabilir
- [ ] Rating state tek yıldız alanı gösteriyor
- [ ] Google CTA state doğru görünüyor
- [ ] Feedback state doğru görünüyor
- [ ] Success state doğru görünüyor

## WooCommerce Order Test

- [ ] Geçerli sipariş için review akışı açılıyor
- [ ] Geçersiz sipariş için güvenli hata gösteriliyor
- [ ] Sipariş durumu beklendiği gibi kontrol ediliyor
- [ ] Sipariş bilgileri gereksiz şekilde görünmüyor
- [ ] Test siparişi ile rating akışı tamamlandı

## AJAX order_key Test

- [ ] AJAX isteklerinde `order_key` doğrulanıyor
- [ ] Geçersiz `order_key` reddediliyor
- [ ] Eksik `order_key` güvenli hata döndürüyor
- [ ] AJAX response hassas veri sızdırmıyor
- [ ] Feedback gönderimi doğru sipariş bağlamında işleniyor

## HPOS Test

- [ ] WooCommerce HPOS açıkken temel akış çalışıyor
- [ ] WooCommerce HPOS kapalıyken temel akış çalışıyor
- [ ] Sipariş okuma işlemleri HPOS uyumlu
- [ ] Eski post meta varsayımlarına bağımlı risk yok

## Translation Test

- [ ] Kullanıcıya görünen metinler çeviriye hazır
- [ ] Text domain doğru kullanılıyor
- [ ] Admin metinleri çeviri kontrolünden geçti
- [ ] Popup metinleri çeviri kontrolünden geçti
- [ ] Readme ve kullanıcı metinlerinde tutarlılık var

## Güvenlik

- [ ] Admin işlemlerinde yetki kontrolü var
- [ ] Nonce kontrolleri var
- [ ] Kullanıcı girdileri doğrulanıyor
- [ ] Kullanıcı girdileri temizleniyor
- [ ] Çıktılar uygun bağlamda kaçışlanıyor
- [ ] Harici servis veya Google yönlendirmesi kullanıcı aksiyonuyla çalışıyor

## Release Kararı

- [ ] Release onaylandı
- [ ] Release ertelendi

## Notlar

Release riskleri, açık konular ve sonraki sprint takip maddeleri.
