<h1>{{ config('app.name') }}</h1>
<p>Merhaba {{ $kullanici->adsoyad }}, Kayıdınız başarılı bir şekilde yapıldı.</p>
<p>Kaydınızı Aktifleştirmek İçin <a href="{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}">Tıklayın.</a> veya aşağıdaki bağlantıyı tarayıcınızda açın.</p>
<p>{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}</p>
