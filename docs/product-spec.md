# Review Redirect for WooCommerce - Product Spec

## Ürün Amacı

Review Redirect for WooCommerce, WooCommerce mağazalarında sipariş sonrası müşteri değerlendirme akışını sade ve kontrollü hale getiren bir WordPress eklentisidir.

Ürün, müşteriye sipariş deneyimini puanlatır. Yüksek memnuniyet durumunda müşteriyi Google yorum aksiyonuna yönlendirir. Düşük memnuniyet durumunda ise mağaza sahibine özel geri bildirim toplama imkanı verir.

Ana amaç, mağazanın olumlu müşteri deneyimlerini görünür yorumlara dönüştürmesine yardımcı olurken, olumsuz deneyimleri önce mağaza içinde yakalayıp çözüm sürecine taşımaktır.

## Hedef Kullanıcı

- WooCommerce kullanan küçük ve orta ölçekli mağaza sahipleri
- Sipariş sonrası müşteri memnuniyetini ölçmek isteyen e-ticaret yöneticileri
- Google işletme yorumlarını artırmak isteyen mağazalar
- Teknik bilgisi sınırlı olan WordPress kullanıcıları

Kullanıcı, karmaşık ayarlarla uğraşmadan eklentiyi kurup temel yönlendirme akışını çalıştırabilmelidir.

## Free Sürüm Kapsamı

Free sürüm aşağıdaki temel işlevleri kapsar:

- WooCommerce siparişine bağlı değerlendirme bağlantısı
- `order_key` ile sipariş doğrulama
- Müşteriye popup üzerinden rating seçimi sunma
- Yüksek rating için Google yorum CTA ekranı
- Düşük rating için özel feedback ekranı
- Başarılı işlem sonrası success state gösterimi
- Temel admin ayarları
- Google yorum bağlantısı ayarı
- Masaüstü ve mobil uyumlu popup deneyimi
- WordPress.org standartlarına uygun paket yapısı

## Bu Sürümde Kesinlikle Olmayacaklar

Bu sürümde aşağıdaki özellikler yer almayacaktır:

- Pro lisans sistemi
- Harici SaaS panel bağlantısı
- Otomatik e-posta gönderimi
- SMS veya WhatsApp entegrasyonu
- Gelişmiş analitik paneli
- Çoklu lokasyon yönetimi
- A/B test sistemi
- Yapay zeka ile yorum üretimi
- Müşteri verisini dış servise gönderme
- Google API üzerinden otomatik yorum gönderme
- WooCommerce dışı sipariş sistemleri

## WordPress.org Hedefi

Review Redirect for WooCommerce free sürümü WordPress.org eklenti dizinine uygun olacak şekilde hazırlanmalıdır.

Zorunlu hedefler:

- GPL uyumlu lisans
- WordPress.org readme standardına uyum
- Kullanıcıdan açık izin almadan takip veya telemetri yapmama
- Harici servis kullanımını açıkça belgeleme
- Uzak kod çalıştırmama
- Yönetici bildirimlerini ölçülü tutma
- Pro yönlendirmesini baskılayıcı hale getirmeme
- Tüm kullanıcıya görünen metinleri çeviriye hazır tutma

## Başarı Kriterleri

Ürün bu sprint sonunda başarılı kabul edilebilmek için:

- Siparişe özel review akışı güvenli şekilde açılmalı
- Geçerli `order_key` olmadan sipariş deneyimi gösterilmemeli
- Rating state tek ve net bir yıldız alanı içermeli
- Desktop popup yatay scroll üretmemeli
- Mobile popup ekran dışına taşmamalı
- Google CTA yalnızca yüksek memnuniyet akışında görünmeli
- Feedback ekranı düşük memnuniyet akışında net çalışmalı
- Success state kullanıcıya işlemin tamamlandığını açıkça bildirmeli
- Plugin Check kritik hata üretmemeli
- Production ZIP içinde geliştirme artıkları bulunmamalı

## Güvenlik Sınırları

Review Redirect güvenlik açısından aşağıdaki sınırlar içinde kalmalıdır:

- Sipariş doğrulaması `order_key` üzerinden yapılır.
- Sipariş bilgileri yalnızca gerekli minimum seviyede kullanılır.
- Admin ayarları yetki kontrolü olmadan değiştirilemez.
- Form işlemleri nonce kontrolü gerektirir.
- Kullanıcı girdileri doğrulanır, temizlenir ve uygun bağlamda kaçışlanır.
- AJAX istekleri sipariş ve yetki bağlamına göre kontrol edilir.
- Feedback içeriği ham HTML olarak saklanmaz veya basılmaz.
- Harici servise müşteri verisi gönderilmez.
- Google yönlendirmesi yalnızca kullanıcı aksiyonuyla yapılır.
- Hata mesajları siparişe ait hassas bilgileri açığa çıkarmaz.

## Açık Not

Bu doküman, sonraki uygulama sprintlerinde kapsam kararlarının ana kaynağıdır. Kod veya UI kararı bu dosyadaki kapsamla çelişirse önce doküman güncellenmelidir.
