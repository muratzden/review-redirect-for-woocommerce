# Review Redirect for WooCommerce - UI Spec

## UI Amacı

Review Redirect popup arayüzü, müşterinin sipariş deneyimini hızlıca puanlamasını ve doğru sonraki adıma yönlenmesini sağlar.

Arayüz tek görevli, sade, hızlı anlaşılır ve mobilde güvenli kullanılabilir olmalıdır.

## Popup State'leri

Popup aşağıdaki state'lerden oluşur:

- Rating state
- Google CTA state
- Feedback state
- Success state
- Error state
- Loading state

Her state tek bir ana aksiyon taşır. Aynı anda birden fazla ana karar alanı gösterilmez.

## Desktop Görünüm

Desktop popup:

- Ekranın ortasında konumlanır.
- İçerik genişliği kontrollü olmalıdır.
- Yatay scroll üretmemelidir.
- Rating, başlık, açıklama ve aksiyonlar tek görsel hiyerarşi içinde görünmelidir.
- Popup kullanıcıyı boğacak ölçüde büyük olmamalıdır.
- Gereksiz boşluklarla ekran hissi gevşetilmemelidir.

## Mobile Görünüm

Mobile popup:

- Ekran genişliğine uyum sağlamalıdır.
- Kenarlarda güvenli boşluk bırakmalıdır.
- İçerik viewport dışına taşmamalıdır.
- Butonlar dokunmaya uygun yükseklikte olmalıdır.
- Yıldız alanı tek satırda kalmalı veya kontrollü şekilde daralmalıdır.
- Yatay scroll kesinlikle oluşmamalıdır.

## Rating State

Rating state müşterinin sipariş deneyimini puanladığı ilk ekrandır.

Zorunlu davranış:

- Tek yıldız alanı bulunur.
- Çift yıldız alanı gösterilmez.
- Seçilen rating görsel olarak net ayrılır.
- Rating seçilmeden sonraki aksiyon tetiklenmez.
- Yüksek rating Google CTA state'e gider.
- Düşük rating Feedback state'e gider.

## Google CTA State

Google CTA state yalnızca yüksek memnuniyet durumunda gösterilir.

Zorunlu davranış:

- Kullanıcıya Google yorumu bırakma çağrısı yapılır.
- CTA metni açık ve kısa olur.
- Google linki kullanıcı aksiyonuyla açılır.
- Otomatik yönlendirme yapılmaz.
- İkincil aksiyon olarak popup kapatma veya sonra devam etme sunulabilir.

## Feedback State

Feedback state düşük memnuniyet durumunda gösterilir.

Zorunlu davranış:

- Kullanıcıdan kısa geri bildirim istenir.
- Metin alanı sade ve anlaşılır olur.
- Gönder butonu tek ana aksiyon olarak görünür.
- Girdi boşsa kullanıcıya anlaşılır hata mesajı gösterilir.
- Feedback gönderimi sonrası Success state açılır.

## Success State

Success state işlemin tamamlandığını bildirir.

Zorunlu davranış:

- Kullanıcıya teşekkür edilir.
- İşlemin tamamlandığı net söylenir.
- Ek karar yükü oluşturulmaz.
- Popup kapatma aksiyonu açık şekilde sunulur.

## Ölçüler

Temel ölçü kararları:

- Desktop popup maksimum genişliği kontrollü ve okunabilir olmalıdır.
- Mobile popup viewport genişliğine göre daralmalıdır.
- İçerik alanı popup sınırlarını zorlamamalıdır.
- Butonlar dokunma hedefi için yeterli yüksekliğe sahip olmalıdır.
- Yıldız alanı popup genişliğini aşmamalıdır.

Kesin piksel değerleri uygulama sprintinde mevcut tema ve bileşen yapısı okunarak belirlenecektir. Codex kendi başına yeni tasarım sistemi icat etmeyecektir.

## Spacing

Spacing kuralları:

- Başlık, açıklama, rating ve aksiyonlar arasında net ama kompakt boşluk kullanılır.
- Büyük boş alanlar kullanılmaz.
- Form alanları ve butonlar birbirinden kolay ayırt edilir.
- Mobile görünümde boşluklar küçültülür ancak dokunma alanları korunur.

## Typography

Typography kuralları:

- Başlık kısa ve net olur.
- Açıklama metni tek amaca hizmet eder.
- Buton metinleri doğrudan aksiyon bildirir.
- Hata ve başarı mesajları teknik olmayan dille yazılır.
- Font boyutları viewport'a göre kontrolsüz büyütülmez.

## Accessibility

Erişilebilirlik gereksinimleri:

- Popup klavye ile kullanılabilir olmalıdır.
- Odak popup içine taşınmalı ve mantıklı sırayla ilerlemelidir.
- Kapatma aksiyonu klavye ve ekran okuyucu için erişilebilir olmalıdır.
- Rating alanı yalnızca görsel yıldızlardan ibaret olmamalıdır.
- Seçili rating ekran okuyucu tarafından anlaşılmalıdır.
- Hata mesajları ilgili alanla ilişkilendirilmelidir.
- Renk tek başına durum göstergesi olarak kullanılmamalıdır.

## Responsive Kurallar

- Desktop ve mobile aynı akışı kullanır, yalnızca düzen uyarlanır.
- Popup hiçbir kırılımda yatay scroll üretmez.
- İçerik taşarsa dikey kaydırma kontrollü olmalıdır.
- CTA butonları dar ekranda okunur kalmalıdır.
- Yıldız alanı dar ekranda kırılma veya taşma üretmemelidir.
- Popup ekranın tamamını gereksiz yere kaplamamalıdır.

## Eski Tasarımda Yasaklanan Davranışlar

Aşağıdaki davranışlar kesin olarak yasaktır:

- Çift yıldız alanı göstermek
- Yatay scroll üretmek
- Aşırı büyük modal kullanmak
- Gereksiz boşluklarla popup'ı şişirmek
- Codex'in mevcut ürün kararlarından bağımsız kendi tasarım kararını üretmesi
- Rating ve feedback akışını aynı anda aynı ekranda sıkıştırmak
- Google CTA'yı düşük rating state'inde göstermek
- Mobilde butonları veya yıldızları ekran dışına taşırmak

## UI Kabul Kriterleri

- Desktop popup kompakt, okunabilir ve scrollsuz görünür.
- Mobile popup ekran dışına taşmadan kullanılabilir.
- Rating state yalnızca bir yıldız alanı içerir.
- Google CTA ve Feedback state doğru rating koşullarında açılır.
- Success state açık ve sakin bir tamamlanma mesajı verir.
- Codex uygulama sprintinde bu dokümandaki yasakları ihlal etmez.
