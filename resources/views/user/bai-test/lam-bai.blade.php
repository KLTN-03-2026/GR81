@extends('layouts.app')
@section('title', 'Làm bài test MBTI')

@section('css')
    .q-slide { display: none; }
    .q-slide.active { display: block; }

    .question-card { background: #fff; border-radius: 12px; border: 1px solid #e8ecf1; }
    .question-top { padding: 16px 24px; border-bottom: 1px solid #f1f3f5; display: flex; justify-content: space-between; align-items: center; }
    .question-num { font-size: 13px; font-weight: 600; color: #1a1a2e; }
    .question-dim { font-size: 12px; font-weight: 500; }
    .question-body { padding: 24px; }
    .question-text { font-size: 16px; font-weight: 600; color: #1a1a2e; margin-bottom: 20px; line-height: 1.5; }

    .option { display: flex; align-items: center; gap: 14px; padding: 14px 18px; border: 1px solid #e8ecf1; border-radius: 10px; cursor: pointer; transition: all 0.2s; margin-bottom: 10px; background: #fff; }
    .option:hover { border-color: #34d399; background: #fafffe; }
    .option.selected { border-color: #34d399; background: #f0fdf4; }
    .option-letter { width: 32px; height: 32px; border-radius: 8px; background: #f1f3f5; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 13px; color: #666; flex-shrink: 0; transition: 0.2s; }
    .option.selected .option-letter { background: #34d399; color: #fff; }
    .option-text { font-size: 14px; color: #333; }

    .test-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .nav-btn { display: flex; align-items: center; gap: 6px; padding: 10px 20px; border: 1px solid #e8ecf1; border-radius: 8px; background: #fff; color: #555; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; font-family: 'Inter', sans-serif; }
    .nav-btn:hover { border-color: #34d399; color: #059669; }
    .nav-btn.green { background: #34d399; color: #fff; border-color: #34d399; }
    .nav-btn.green:hover { background: #059669; }
    .nav-btn:disabled { opacity: 0.35; pointer-events: none; }

    .dots { display: flex; flex-wrap: wrap; gap: 3px; margin-top: 12px; background: #fff; border-radius: 10px; border: 1px solid #e8ecf1; padding: 12px 16px; }
    .dot { width: 26px; height: 26px; border-radius: 5px; border: 1px solid #e8ecf1; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #bbb; cursor: pointer; transition: 0.15s; }
    .dot:hover { border-color: #34d399; color: #059669; }
    .dot.done { background: #34d399; color: #fff; border-color: #34d399; }
    .dot.now { border-color: #059669; color: #059669; font-weight: 700; }

    .progress-track { height: 6px; background: #f1f3f5; border-radius: 3px; }
    .progress-bar { height: 100%; background: #34d399; border-radius: 3px; transition: width 0.3s; }
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Làm bài test</h1>
    <span style="font-size:14px;font-weight:600;color:#059669;" id="counter">0/{{ count($cauHoi) }}</span>
</div>

<!-- Progress -->
<div style="margin-bottom:6px;">
    <div class="progress-track"><div class="progress-bar" id="pbar" style="width:0%"></div></div>
</div>
<div style="display:flex;gap:8px;margin-bottom:16px;">
    <span class="mbti-badge mbti-green" id="b-EI" style="cursor:pointer;" onclick="jumpTo('EI')">E/I · 0/18</span>
    <span class="mbti-badge mbti-blue" id="b-SN" style="cursor:pointer;" onclick="jumpTo('SN')">S/N · 0/17</span>
    <span class="mbti-badge mbti-purple" id="b-TF" style="cursor:pointer;" onclick="jumpTo('TF')">T/F · 0/17</span>
    <span class="mbti-badge mbti-orange" id="b-JP" style="cursor:pointer;" onclick="jumpTo('JP')">J/P · 0/18</span>
</div>

<!-- Questions -->
<form id="testForm" method="POST" action="/bai-test/nop-bai">
    @csrf
    @foreach($cauHoi as $i => $cau)
    <div class="q-slide {{ $i == 0 ? 'active' : '' }}" data-i="{{ $i }}" data-g="{{ $cau->nhom_chieu }}">
        <div class="question-card">
            <div class="question-top">
                <span class="question-num">Câu {{ $i + 1 }} / {{ count($cauHoi) }}</span>
                <span class="question-dim mbti-badge {{ ['EI'=>'mbti-green','SN'=>'mbti-blue','TF'=>'mbti-purple','JP'=>'mbti-orange'][$cau->nhom_chieu] }}">{{ $cau->nhom_chieu }}</span>
            </div>
            <div class="question-body">
                <div class="question-text">{{ $cau->noi_dung }}</div>
                <div class="option" onclick="pick(this,{{ $cau->id }},'A',{{ $i }})">
                    <span class="option-letter">A</span>
                    <span class="option-text">{{ $cau->lua_chon_a }}</span>
                </div>
                <div class="option" onclick="pick(this,{{ $cau->id }},'B',{{ $i }})">
                    <span class="option-letter">B</span>
                    <span class="option-text">{{ $cau->lua_chon_b }}</span>
                </div>
            </div>
        </div>
        <input type="hidden" name="tra_loi[{{ $i }}][cau_hoi_id]" value="{{ $cau->id }}">
        <input type="hidden" name="tra_loi[{{ $i }}][lua_chon]" id="a{{ $i }}" value="">
    </div>
    @endforeach

    <div class="test-nav">
        <button type="button" class="nav-btn" id="prevBtn" onclick="go(-1)" disabled><i class="bi bi-arrow-left"></i> Trước</button>
        <span style="font-size:12px;color:#999;" id="navLabel">1 / {{ count($cauHoi) }}</span>
        <button type="button" class="nav-btn green" id="nextBtn" onclick="go(1)">Tiếp <i class="bi bi-arrow-right"></i></button>
        <button type="button" class="nav-btn green" id="submitBtn" onclick="nopBai()" style="display:none;"><i class="bi bi-check2"></i> Nộp bài</button>
    </div>
</form>

<!-- Dot nav -->
<div class="dots" id="dots">
    @for($i = 0; $i < count($cauHoi); $i++)
    <div class="dot {{ $i == 0 ? 'now' : '' }}" onclick="goTo({{ $i }})">{{ $i+1 }}</div>
    @endfor
</div>
@endsection

@section('js')
<script>
const T = {{ count($cauHoi) }};
let cur = 0, ans = {};
const sec = {};
document.querySelectorAll('.q-slide').forEach(s => {
    const g = s.dataset.g;
    sec[g] = sec[g] || { t: 0, d: 0 };
    sec[g].t++;
});

function pick(el, id, ch, i) {
    el.parentNode.querySelectorAll('.option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    const g = el.closest('.q-slide').dataset.g;
    if (!ans[i]) sec[g].d++;
    ans[i] = ch;
    document.getElementById('a' + i).value = ch;
    upd();
    setTimeout(() => { if (cur < T - 1) go(1); }, 350);
}

function go(d) {
    const s = document.querySelectorAll('.q-slide');
    s[cur].classList.remove('active');
    cur = Math.max(0, Math.min(T - 1, cur + d));
    s[cur].classList.add('active');
    upd();
}

function goTo(i) { 
    document.querySelectorAll('.q-slide')[cur].classList.remove('active');
    cur = i;
    document.querySelectorAll('.q-slide')[cur].classList.add('active');
    upd();
}

function jumpTo(g) {
    const s = document.querySelectorAll('.q-slide');
    for (let i = 0; i < s.length; i++) if (s[i].dataset.g === g) { goTo(i); break; }
}

function upd() {
    const n = Object.keys(ans).length;
    document.getElementById('counter').textContent = n + '/' + T;
    document.getElementById('pbar').style.width = (n / T * 100) + '%';
    document.getElementById('navLabel').textContent = (cur + 1) + ' / ' + T;
    document.getElementById('prevBtn').disabled = cur === 0;
    document.getElementById('nextBtn').style.display = cur < T - 1 ? '' : 'none';
    document.getElementById('submitBtn').style.display = cur === T - 1 ? '' : 'none';

    const labels = { EI: 'E/I', SN: 'S/N', TF: 'T/F', JP: 'J/P' };
    for (const [k, v] of Object.entries(sec)) {
        document.getElementById('b-' + k).textContent = labels[k] + ' · ' + v.d + '/' + v.t;
    }

    document.querySelectorAll('.dot').forEach((d, i) => {
        d.className = 'dot' + (i === cur ? ' now' : '') + (ans[i] ? ' done' : '');
    });
}

function nopBai() {
    const n = Object.keys(ans).length;
    if (n < T) { 
        for (let i = 0; i < T; i++) { if (!ans[i]) { goTo(i); alert('Vui lòng trả lời câu ' + (i+1)); return; } }
    }
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = 'Đang xử lý...';
    const fd = new FormData(document.getElementById('testForm'));
    fetch('/bai-test/nop-bai', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(d => { if (d.redirect) window.location.href = d.redirect; })
        .catch(() => { alert('Lỗi! Thử lại.'); document.getElementById('submitBtn').disabled = false; document.getElementById('submitBtn').innerHTML = '<i class="bi bi-check2"></i> Nộp bài'; });
}

document.addEventListener('keydown', e => {
    if (e.key === 'ArrowRight' && cur < T - 1) go(1);
    if (e.key === 'ArrowLeft' && cur > 0) go(-1);
    if (e.key === 'a' || e.key === 'A' || e.key === '1') document.querySelectorAll('.q-slide')[cur].querySelectorAll('.option')[0].click();
    if (e.key === 'b' || e.key === 'B' || e.key === '2') document.querySelectorAll('.q-slide')[cur].querySelectorAll('.option')[1].click();
});
</script>
@endsection
