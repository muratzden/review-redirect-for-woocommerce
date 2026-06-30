# Review Redirect for WooCommerce Popup UI Spec

Bu dokuman, Review Redirect for WooCommerce popup arayuzunun RC2 kapsamindaki sabit, kontrollu ve premium tasarim standardini tanimlar.

Bu sprintte yeni ozellik, provider sistemi, analytics/dashboard, admin ayar mantigi veya AJAX guvenlik mantigi eklenmez. Kapsam yalnizca popup HTML/CSS/JS sunumu, responsive davranis ve surum guncellemesidir.

## Desktop Gorunum

Desktop popup koyu ve hafif blur uygulanmis bir overlay uzerinde gosterilir.

Modal olculeri:

- Genislik: 440px.
- Maksimum genislik: calc(100vw - 32px).
- Yukseklik: Icerik kadar.
- Border radius: 24px.
- Padding: 28px.
- Yatay scroll: Asla olusmamali.
- Dikey scroll: Normal sartlarda olusmamali.

Modal yapisi:

1. Ust satirda solda kucuk badge, sagda close button bulunur.
2. Badge metni: "Order Feedback".
3. Close button 36x36 px olmali ve basligi ezmemelidir.
4. Ortada sade yildiz ikon alani bulunur.
5. Buyuk sari kapsul veya dekoratif yildiz arka plani kullanilmaz.
6. Baslik: "How did we do?"
7. Aciklama: "Your opinion helps us improve and helps other customers choose with confidence."
8. Rating yildizlari tek satirda gosterilir.
9. Pozitif rating durumunda Google CTA ve yardimci metin gosterilir.
10. Dusuk rating durumunda feedback form gosterilir.

## Tablet Gorunum

Tablet gorunum desktop yapisini korur, ancak modal ekran kenarlarina yaklasmayacak sekilde esnek davranir.

Kurallar:

- Modal genisligi ekran genisligine gore daralabilir.
- Maksimum genislik siniri korunur.
- Icerik tek kolon kalir.
- Yildiz satiri tek satirda kalmali ve tasmamalidir.
- Butonlar okunabilir ve rahat tiklanabilir olmalidir.
- Modal yatay scroll uretmemelidir.

## Mobile Gorunum

Mobilde popup daha kompakt ve dokunmatik kullanima uygun olmalidir.

Modal olculeri:

- Genislik: calc(100vw - 24px).
- Padding: 20px.
- Border radius: 20px.
- Yildiz boyutu: 30px.
- Yildiz gap: 6px.
- Textarea minimum yuksekligi: 104px.

Mobil kurallar:

- Google CTA butonu full width olmalidir.
- Submit butonu full width olmalidir.
- Modal hicbir sekilde yatay scroll uretmemelidir.
- WordPress admin bar gorunur olsa bile modal tasmamalidir.
- Baslik, aciklama, buton ve form metinleri kapsayici disina cikmamalidir.
- Close button ust satirda kalmali ve icerikle cakismamalidir.

## 5 Yildiz Akisi

Kullanici threshold degerine esit veya daha yuksek bir rating sectiginde pozitif akis baslar.

Akis:

1. Kullanici rating yildizlarindan birini secer.
2. Secilen puana kadar olan yildizlar aktif altin renkte gosterilir.
3. Google CTA alani gorunur olur.
4. Feedback form gizlenir.
5. Yardimci metin gosterilir: "Your review helps other customers discover our store."
6. Google CTA tiklaninca success mesaji gosterilir: "Thank you for supporting our business!"
7. Google click success sonrasi popup 2 saniye sonra kapanir.

## Dusuk Puan Akisi

Kullanici threshold degerinin altinda bir rating sectiginde feedback akisi baslar.

Akis:

1. Kullanici dusuk puan secer.
2. Secilen puana kadar olan yildizlar aktif altin renkte gosterilir.
3. Google CTA gizlenir.
4. Feedback form gorunur olur.
5. Label gosterilir: "What could we improve?"
6. Placeholder gosterilir: "Tell us what we could have done better..."
7. Kullanici feedback gonderir.
8. Form gizlenir.
9. Success mesaji gosterilir: "Thank you for your feedback."

## Feedback Success

Feedback basariyla gonderildiginde form alani gizlenir ve kullaniciya kisa, net bir tesekkur mesaji gosterilir.

Mesaj:

"Thank you for your feedback."

Kurallar:

- Success mesaji popup icinde gosterilir.
- Gereksiz yeni aksiyon eklenmez.
- Kullanici isterse close button ile popup kapatabilir.

## Google Click Success

Google CTA tiklandiginda CTA alani gizlenir veya success durumuna gecer.

Mesaj:

"Thank you for supporting our business!"

Kurallar:

- Mesaj popup icinde gosterilir.
- Popup 2 saniye sonra kapanir.
- Kullanici close button ile daha erken kapatabilmelidir.

## Olculer

Desktop:

- Modal width: 440px.
- Modal max-width: calc(100vw - 32px).
- Padding: 28px.
- Radius: 24px.
- Close button: 36x36 px.
- Rating star size: 34px.
- Rating star gap: 10px.

Mobile:

- Modal width: calc(100vw - 24px).
- Padding: 20px.
- Radius: 20px.
- Rating star size: 30px.
- Rating star gap: 6px.
- Textarea min-height: 104px.

## Spacing

Spacing sade, dengeli ve tasma uretmeyecek sekilde uygulanir.

Kurallar:

- Ust satir badge ve close button arasinda yeterli bosluk birakir.
- Ikon alani baslikla dengeli mesafede durur.
- Baslik ve aciklama birbirine yakin ama okunabilir olmalidir.
- Rating yildizlari tek satirda kalacak sekilde araliklandirilir.
- CTA, yardimci metin ve form alanlari icerik akisina gore dogal boslukla ayrilir.
- Mobilde bosluklar sikistirilir ancak dokunmatik hedefler korunur.

## Typography

Tipografi premium, sade ve okunabilir olmalidir.

Kurallar:

- Baslik kisa, guclu ve merkezde algilanabilir olmalidir.
- Aciklama metni ikincil gorsel agirlikta olmalidir.
- Badge kucuk ve yardimci bir baglam etiketi gibi davranmalidir.
- Form label net ve dogrudan olmalidir.
- Buton metinleri kisa, okunabilir ve aksiyon odakli olmalidir.
- Mobilde metinler satir kirabilir, ancak yatay tasma olusturmamalidir.

## Renkler

Renk kullanimi kontrollu ve anlamli olmalidir.

Kurallar:

- Overlay koyu ve hafif blur etkili olmalidir.
- Modal yuzeyi acik, temiz ve kontrastli olmalidir.
- Aktif yildizlar altin renkte gosterilir.
- Pasif yildizlar dusuk kontrastli notr renkte gosterilir.
- Primary CTA belirgin olmalidir.
- Success mesajlari olumlu ama abartisiz bir tonla gosterilmelidir.
- Hata veya feedback alanlarinda renk tek basina anlam tasimamalidir.

## Mobil Kurallar

Mobil popup dar ekranlarda guvenli ve tasmasiz calismalidir.

Zorunlu kurallar:

- Popup ve tum alt ogeleri border-box kullanmalidir.
- Popup overflow-x: hidden kullanmalidir.
- Dialog overflow-x: hidden kullanmalidir.
- img, svg, button ve textarea max-width: 100% sinirini asmamalidir.
- Buyuk sabit genislik kullanilmamalidir.
- Gereksiz min-height kullanilmamalidir.
- Rating satiri modal disina tasmamalidir.
- WordPress admin bar varsa popup gorunur alan icinde kalmalidir.

## Accessibility

Popup erisilebilirlik davranislarini korumalidir.

Kurallar:

- ESC ile kapanma korunmalidir.
- Close button aria-label korunmalidir.
- Rating buttons aria-label degerleri korunmalidir.
- Focus outline gorunur olmalidir.
- Klavye ile etkilesim mumkun olmalidir.
- prefers-reduced-motion desteklenmelidir.
- Success ve state degisimleri kullaniciya anlasilir sekilde sunulmalidir.
