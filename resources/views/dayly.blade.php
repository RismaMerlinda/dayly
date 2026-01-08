<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dayly</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .feature-btn{
        padding: 12px 24px;
        border-radius: 14px;
        background: white;
        box-shadow: 0 10px 20px rgba(0,0,0,.06);
        font-weight: 500;
        transition: all .3s ease;
    }
    .feature-btn:hover,
    .feature-btn.active{
        background: #4f46e5;
        color: white;
    }
    .feature-card{
        display: none;
    }
    .feature-card.show{
        display: block;
        animation: slideFade .4s ease-out;
    }
    @keyframes slideFade{
        from{
            opacity:0;
            transform: translateY(20px);
        }
        to{
            opacity:1;
            transform: translateY(0);
        }
    }
</style>
</head>

<body class="bg-slate-50 text-slate-800">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full bg-white/80 backdrop-blur border-b z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">
        <h1 class="text-xl font-bold text-indigo-600">Dayly</h1>
        <ul class="flex gap-6 text-sm font-medium">
            <li><a href="#home">Home</a></li>
            <li><a href="#features">Features</a></li>
        </ul>
    </div>
</nav>

<!-- HOME -->
<section id="home" class="pt-36 pb-32 bg-gradient-to-br from-indigo-50 via-blue-50 to-sky-100">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-5xl font-extrabold mb-6">
            Daily Date Utilities <br>
            <span class="text-indigo-600">Simple & Accurate</span>
        </h2>

        <p class="max-w-3xl mx-auto text-slate-600 text-lg mb-6 leading-relaxed">
            <b>Dayly</b> adalah aplikasi berbasis web menggunakan framework
            <b>Laravel</b> yang dirancang untuk membantu pengguna dalam
            pengolahan data tanggal secara sistematis dan akurat.
        </p>

        <p class="max-w-3xl mx-auto text-slate-600 text-lg mb-12 leading-relaxed">
            Aplikasi ini menyediakan fitur penentuan hari kerja atau hari libur,
            perhitungan umur, validasi tanggal, serta perhitungan jumlah hari kerja
            dalam suatu rentang tanggal.
        </p>

        <div class="inline-flex flex-col bg-white px-10 py-6 rounded-3xl shadow-md">
            <span class="text-sm text-slate-500">📅 Tanggal Hari Ini</span>
            <span class="text-2xl font-semibold mt-1">{{ $todayFormatted }}</span>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="py-24">
    <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-bold text-center mb-12">
            Pilih Fitur
        </h3>

        <!-- selector -->
        <div class="flex flex-wrap justify-center gap-4 mb-16">
            <button class="feature-btn" onclick="showFeature('workday',this)">Hari Kerja</button>
            <button class="feature-btn" onclick="showFeature('age',this)">Hitung Umur</button>
            <button class="feature-btn" onclick="showFeature('validate',this)">Validasi</button>
            <button class="feature-btn" onclick="showFeature('range',this)">Hari Kerja Range</button>
        </div>

        <!-- HARI KERJA -->
        <div id="workday" class="feature-card">
            <div class="bg-white p-10 rounded-3xl shadow max-w-xl mx-auto">
                <h4 class="text-xl font-semibold mb-6 text-indigo-600">
                    Hari Kerja / Hari Libur
                </h4>
                
                <form method="POST" action="/process">
                    @csrf
                    <input type="date" name="work_date"
                    class="w-full border rounded-xl px-4 py-3 mb-4">
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-xl">
                        Cek Hari
                    </button>
                </form>

                @if(session('result.workday'))
                <p class="mt-6 font-medium text-center animate-show">
                    {{ session('result.workday') }}
                </p>
                @endif
            </div>
        </div>

        <!-- UMUR -->
        <div id="age" class="feature-card">
            <div class="bg-white p-10 rounded-3xl shadow max-w-xl mx-auto">
                <h4 class="text-xl font-semibold mb-6 text-indigo-600">
                    Hitung Umur
                </h4>

                <form method="POST" action="/process">
                    @csrf
                    <input type="date" name="birth_date"
                    class="w-full border rounded-xl px-4 py-3 mb-4">
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-xl">
                        Hitung Umur
                    </button>
                </form>

                @if(session('result.age'))
                <p class="mt-6 text-center text-lg">
                    🎂 {{ session('result.age') }}
                </p>
                @endif
            </div>
        </div>

        <!-- VALIDASI -->
        <div id="validate" class="feature-card">
            <div class="bg-white p-10 rounded-3xl shadow max-w-xl mx-auto">
                <h4 class="text-xl font-semibold mb-6 text-indigo-600">
                    Validasi Tanggal
                </h4>

                <form method="POST" action="/process">
                    @csrf
                    <input type="date" name="validate_date"
                    class="w-full border rounded-xl px-4 py-3 mb-4">
                    <button class="w-full bg-indigo-600 text-white py-3 rounded-xl">
                        Validasi
                    </button>
                </form>

                @if(session('result.validation'))
                <p class="mt-6 text-center">
                    {{ session('result.validation') }}
                </p>
                @endif
            </div>
        </div>

        <!-- RANGE -->
        <div id="range" class="feature-card">
            <div class="bg-white p-10 rounded-3xl shadow max-w-2xl mx-auto">
                <h4 class="text-xl font-semibold mb-6 text-indigo-600">
                    Jumlah Hari Kerja
                </h4>

                <form method="POST" action="/process" class="grid md:grid-cols-2 gap-4">
                    @csrf
                    <input type="date" name="start_date" class="border rounded-xl px-4 py-3">
                    <input type="date" name="end_date" class="border rounded-xl px-4 py-3">
                    <button class="md:col-span-2 bg-indigo-600 text-white py-3 rounded-xl">
                        Hitung
                    </button>
                </form>

                @if(session('result.workdays_count'))
                <p class="mt-6 text-center font-medium">
                    📊 Jumlah Hari Kerja:
                    <b>{{ session('result.workdays_count') }}</b> hari
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-900 text-slate-400 py-10 text-center">
    © {{ date('Y') }} Dayly · Built by Risma Merlinda
</footer>

<script>
function showFeature(id,btn){
    document.querySelectorAll('.feature-card').forEach(c=>c.classList.remove('show'));
    document.querySelectorAll('.feature-btn').forEach(b=>b.classList.remove('active'));
    document.getElementById(id).classList.add('show');
    btn.classList.add('active');
}
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    let featureId = null;
    let btn = null;

    @if(session('result'))
        @if(session('result.workday'))
            featureId = 'workday';
            btn = document.querySelector("button[onclick*='workday']");
        @elseif(session('result.age'))
            featureId = 'age';
            btn = document.querySelector("button[onclick*='age']");
        @elseif(session('result.validation'))
            featureId = 'validate';
            btn = document.querySelector("button[onclick*='validate']");
        @elseif(session('result.workdays_count'))
            featureId = 'range';
            btn = document.querySelector("button[onclick*='range']");
        @endif
    @endif

    if(featureId && btn){
        showFeature(featureId, btn);

        document.getElementById('features')
            .scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});
</script>
</body>
</html>