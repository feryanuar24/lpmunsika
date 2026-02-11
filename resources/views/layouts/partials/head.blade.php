<title>{{ ($data['article']->title ?? config('app.name')) . ' - resonan.lpmunsika.com' }}</title>

<meta charset="utf-8" />
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta
    content="{{ Str::limit(strip_tags($data['article']->content ?? 'LPM Unsika merupakan unit kegiatan mahasiswa yang berperan sebagai wadah untuk menyalurkan bakat dan hobi dalam bidang jurnalistik.'), 160) }}"
    name="description" />
<meta content="@lpmunsika" name="twitter:site" />
<meta content="@lpmunsika" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="{{ ($data['article']->title ?? config('app.name')) . ' - lpmunsika.com' }}" name="twitter:title" />
<meta
    content="{{ Str::limit(strip_tags($data['article']->content ?? 'LPM Unsika merupakan unit kegiatan mahasiswa yang berperan sebagai wadah untuk menyalurkan bakat dan hobi dalam bidang jurnalistik.'), 160) }}"
    name="twitter:description" />
<meta content="{{ isset($data['article']) && $data['article']->thumbnail ? route('files', $data['article']->thumbnail) : asset('assets/media/app/og-image.jpg') }}"
    name="twitter:image" />
<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="id" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="{{ config('app.name') }}" property="og:site_name" />
<meta content="{{ ($data['article']->title ?? config('app.name')) . ' - lpmunsika.com' }}" property="og:title" />
<meta
    content="{{ Str::limit(strip_tags($data['article']->content ?? 'LPM Unsika merupakan unit kegiatan mahasiswa yang berperan sebagai wadah untuk menyalurkan bakat dan hobi dalam bidang jurnalistik.'), 160) }}"
    property="og:description" />
<meta content="{{ isset($data['article']) && $data['article']->thumbnail ? route('files', $data['article']->thumbnail) : asset('assets/media/app/og-image.jpg') }}"
    property="og:image" />
<meta name="google-site-verification" content="5J2B-VM6ID8EqfWLLkVcXbxdfBOy922JX2L8Q1B0nx8" />
<link href="{{ asset('assets/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
<link href="{{ asset('assets/media/app/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png" />
<link href="{{ asset('assets/media/app/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png" />
<link href="{{ asset('assets/media/app/favicon.ico') }}" rel="shortcut icon" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
@stack('styles')
