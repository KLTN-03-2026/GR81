@extends('layouts.app')
@section('title', 'Phân tích CV bằng AI')

@section('content')
<div class="page-header">
    <h1 class="page-title">Phân tích CV bằng AI</h1>
    <p style="color:#64748b;font-size:14px;">Upload file CV hoặc nhập nội dung để AI phân tích và đề xuất ngách nghề nghiệp</p>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <!-- Form nhập CV -->
    <div>
        <div class="card">
            <div class="card-body">
                @if($ketQua)
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:12px;">
                    <strong style="color:#059669;">MBTI: {{ $ketQua->kieu_mbti }}</strong> — Kết quả MBTI sẽ được kết hợp vào phân tích CV
                </div>
                @endif

                <form method="POST" action="/phan-tich-cv" id="formCV" enctype="multipart/form-data">
                    @csrf

                    <!-- Tab chuyển đổi -->
                    <div style="display:flex;border-bottom:2px solid #f1f5f9;margin-bottom:16px;">
                        <button type="button" class="cv-tab active" data-tab="upload" onclick="switchTab('upload')" style="flex:1;padding:10px;font-size:13px;font-weight:600;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;color:#64748b;">
                            <i class="bi bi-cloud-upload"></i> Upload file
                        </button>
                        <button type="button" class="cv-tab" data-tab="text" onclick="switchTab('text')" style="flex:1;padding:10px;font-size:13px;font-weight:600;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;color:#64748b;">
                            <i class="bi bi-keyboard"></i> Nhập văn bản
                        </button>
                    </div>

                    <!-- Tab Upload file -->
                    <div id="tabUpload">
                        <div id="dropZone" style="border:2px dashed #d1d5db;border-radius:12px;padding:40px 20px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafafa;"
                             onmouseover="this.style.borderColor='#059669';this.style.background='#f0fdf4'"
                             onmouseout="this.style.borderColor='#d1d5db';this.style.background='#fafafa'"
                             ondragover="event.preventDefault();this.style.borderColor='#059669';this.style.background='#f0fdf4'"
                             ondragleave="this.style.borderColor='#d1d5db';this.style.background='#fafafa'"
                             ondrop="event.preventDefault();handleDrop(event)">
                            <input type="file" name="file_cv" id="fileInput" accept=".pdf,.doc,.docx,.txt" style="display:none;">
                            <div id="uploadIcon">
                                <i class="bi bi-cloud-arrow-up" style="font-size:40px;color:#059669;"></i>
                                <p style="font-weight:600;font-size:14px;color:#0f172a;margin-top:12px;">Kéo thả file CV vào đây</p>
                                <p style="font-size:12px;color:#94a3b8;margin-top:4px;">hoặc <span style="color:#059669;font-weight:600;text-decoration:underline;">nhấn để chọn file</span></p>
                                <p style="font-size:11px;color:#cbd5e1;margin-top:8px;">Hỗ trợ: PDF, DOC, DOCX, TXT (tối đa 5MB)</p>
                            </div>
                            <div id="fileInfo" style="display:none;">
                                <i class="bi bi-file-earmark-check" style="font-size:36px;color:#059669;"></i>
                                <p style="font-weight:600;font-size:14px;color:#0f172a;margin-top:8px;" id="fileName"></p>
                                <p style="font-size:12px;color:#94a3b8;" id="fileSize"></p>
                                <button type="button" onclick="clearFile()" style="margin-top:8px;padding:4px 16px;border:1px solid #ef4444;color:#ef4444;border-radius:6px;font-size:12px;background:none;cursor:pointer;">
                                    <i class="bi bi-x"></i> Xóa file
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tab nhập text -->
                    <div id="tabText" style="display:none;">
                        <textarea name="noi_dung_cv" rows="16" placeholder="Dán toàn bộ nội dung CV của bạn vào đây...&#10;&#10;Ví dụ:&#10;- Thông tin cá nhân&#10;- Học vấn&#10;- Kinh nghiệm làm việc&#10;- Kỹ năng&#10;- Dự án đã thực hiện"
                            style="width:100%;border:1px solid #e2e8f0;border-radius:10px;padding:14px;font-size:13px;font-family:'Inter',sans-serif;line-height:1.6;resize:vertical;"
                        >{{ old('noi_dung_cv', $noiDungCv ?? '') }}</textarea>
                    </div>

                    @error('file_cv')
                    <div style="color:#ef4444;font-size:12px;margin-top:8px;">{{ $message }}</div>
                    @enderror
                    @error('noi_dung_cv')
                    <div style="color:#ef4444;font-size:12px;margin-top:8px;">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:16px;" id="btnCV">
                        <i class="bi bi-robot"></i> Phân tích CV bằng AI
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Kết quả phân tích -->
    <div>
        @if(isset($ketQuaCV) && is_array($ketQuaCV))
        <div class="card">
            <div class="card-body">
                <div style="font-weight:600;font-size:14px;margin-bottom:16px;">
                    <i class="bi bi-stars" style="color:#059669;"></i> Kết quả phân tích AI
                </div>

                @if(!empty($ketQuaCV['tom_tat_cv']))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px;margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;color:#059669;margin-bottom:6px;"><i class="bi bi-person-vcard"></i> Tóm tắt CV</div>
                    <p style="font-size:13px;color:#444;line-height:1.7;margin:0;">{{ $ketQuaCV['tom_tat_cv'] }}</p>
                </div>
                @endif

                @if(!empty($ketQuaCV['diem_manh_tu_cv']))
                <div style="margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;margin-bottom:8px;"><i class="bi bi-trophy" style="color:#d97706;"></i> Điểm mạnh từ CV</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach($ketQuaCV['diem_manh_tu_cv'] as $dm)
                        <span style="background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:500;">{{ $dm }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($ketQuaCV['diem_can_cai_thien']))
                <div style="margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;margin-bottom:8px;"><i class="bi bi-exclamation-triangle" style="color:#ef4444;"></i> Điểm cần cải thiện</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach($ketQuaCV['diem_can_cai_thien'] as $dc)
                        <span style="background:#fef2f2;color:#991b1b;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:500;">{{ $dc }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($ketQuaCV['ngach_nghe_nghiep']))
                <div style="margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;margin-bottom:12px;"><i class="bi bi-briefcase" style="color:#059669;"></i> Ngách nghề nghiệp phù hợp</div>
                    @foreach($ketQuaCV['ngach_nghe_nghiep'] as $ngach)
                    <div style="border:1px solid #e2e8f0;border-radius:10px;padding:14px;margin-bottom:10px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span style="font-weight:700;font-size:14px;">{{ $ngach['ten_ngach'] ?? '' }}</span>
                            <span style="background:#dcfce7;color:#166534;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;">{{ $ngach['muc_do_phu_hop'] ?? 0 }}%</span>
                        </div>
                        <div style="height:6px;background:#f1f5f9;border-radius:3px;margin-bottom:8px;">
                            <div style="height:100%;background:linear-gradient(90deg,#34d399,#059669);border-radius:3px;width:{{ $ngach['muc_do_phu_hop'] ?? 0 }}%;"></div>
                        </div>
                        <p style="font-size:12px;color:#64748b;margin:0;line-height:1.6;">{{ $ngach['ly_do'] ?? '' }}</p>
                        @if(!empty($ngach['muc_luong']))
                        <div style="margin-top:6px;font-size:11px;color:#059669;font-weight:600;"><i class="bi bi-cash-stack"></i> {{ $ngach['muc_luong'] }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                @if(!empty($ketQuaCV['lo_trinh_phat_trien']))
                <div style="margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;margin-bottom:8px;"><i class="bi bi-signpost-2" style="color:#2563eb;"></i> Lộ trình phát triển</div>
                    @foreach(['ngan_han' => 'Ngắn hạn (3-6 tháng)', 'trung_han' => 'Trung hạn (6-12 tháng)', 'dai_han' => 'Dài hạn (1-3 năm)'] as $key => $label)
                    @if(!empty($ketQuaCV['lo_trinh_phat_trien'][$key]))
                    <div style="background:#f8fafc;border-left:3px solid #059669;padding:10px 14px;margin-bottom:8px;border-radius:0 8px 8px 0;">
                        <div style="font-weight:600;font-size:12px;color:#059669;">{{ $label }}</div>
                        <p style="font-size:12px;color:#475569;margin:4px 0 0;line-height:1.6;">{{ $ketQuaCV['lo_trinh_phat_trien'][$key] }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                @if(!empty($ketQuaCV['de_xuat_cai_thien_cv']))
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px;margin-bottom:16px;">
                    <div style="font-weight:600;font-size:13px;color:#2563eb;margin-bottom:6px;"><i class="bi bi-pencil-square"></i> Đề xuất cải thiện CV</div>
                    <p style="font-size:13px;color:#444;line-height:1.7;margin:0;">{{ $ketQuaCV['de_xuat_cai_thien_cv'] }}</p>
                </div>
                @endif

                @if(!empty($ketQuaCV['loi_khuyen']))
                <div style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;padding:16px;">
                    <div style="font-weight:600;font-size:13px;color:#7c3aed;margin-bottom:6px;"><i class="bi bi-chat-heart"></i> Lời khuyên</div>
                    <p style="font-size:13px;color:#444;line-height:1.7;margin:0;">{{ $ketQuaCV['loi_khuyen'] }}</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body" style="text-align:center;padding:60px;">
                <i class="bi bi-file-earmark-richtext" style="font-size:48px;color:#ddd;"></i>
                <p style="margin-top:12px;color:#888;font-size:14px;">Upload file CV hoặc nhập nội dung CV bên trái để bắt đầu phân tích.</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Loading Overlay --}}
<div id="cvLoadingOverlay" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
    <div style="text-align:center;max-width:400px;padding:40px;">
        <div style="width:80px;height:80px;margin:0 auto 24px;position:relative;">
            <div style="width:80px;height:80px;border-radius:50%;border:3px solid #e2e8f0;border-top-color:#059669;animation:spin 1s linear infinite;position:absolute;inset:0;"></div>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:32px;color:#059669;animation:pulse 2s ease-in-out infinite;"><i class="bi bi-file-earmark-check"></i></div>
        </div>
        <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">AI đang phân tích CV...</h3>
        <p style="font-size:13px;color:#64748b;">Đang trích xuất thông tin và phân tích. Quá trình này có thể mất 30-60 giây.</p>
        <div style="width:100%;height:6px;background:#f1f5f9;border-radius:3px;overflow:hidden;margin-top:20px;">
            <div style="height:100%;background:linear-gradient(90deg,#34d399,#059669,#34d399);background-size:200% 100%;border-radius:3px;animation:progress 60s ease-out forwards,shimmer 1.5s ease-in-out infinite;"></div>
        </div>
        <div style="font-size:11px;color:#94a3b8;margin-top:8px;">Thời gian: <span id="cvTimer">0</span>s</div>
    </div>
</div>
<style>
@keyframes spin{to{transform:rotate(360deg)}}
@keyframes pulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.15);opacity:0.7}}
@keyframes progress{0%{width:0}100%{width:100%}}
@keyframes shimmer{0%{background-position:200% 0}100%{background-position:-200% 0}}
</style>

<script>
// Tab switching
function switchTab(tab) {
    document.getElementById('tabUpload').style.display = tab === 'upload' ? 'block' : 'none';
    document.getElementById('tabText').style.display = tab === 'text' ? 'block' : 'none';
    document.querySelectorAll('.cv-tab').forEach(t => {
        t.style.borderBottomColor = t.dataset.tab === tab ? '#059669' : 'transparent';
        t.style.color = t.dataset.tab === tab ? '#059669' : '#64748b';
    });
}
// Set initial active tab style
document.querySelector('.cv-tab.active').style.borderBottomColor = '#059669';
document.querySelector('.cv-tab.active').style.color = '#059669';

// Drop zone click
document.getElementById('dropZone').addEventListener('click', () => document.getElementById('fileInput').click());

// File drag & drop
function handleDrop(e) {
    const files = e.dataTransfer.files;
    if (files.length) {
        document.getElementById('fileInput').files = files;
        showFileInfo(files[0]);
    }
}

// File select
document.getElementById('fileInput').addEventListener('change', function() {
    if (this.files[0]) showFileInfo(this.files[0]);
});

function showFileInfo(file) {
    document.getElementById('uploadIcon').style.display = 'none';
    document.getElementById('fileInfo').style.display = 'block';
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
}

function clearFile() {
    document.getElementById('fileInput').value = '';
    document.getElementById('uploadIcon').style.display = 'block';
    document.getElementById('fileInfo').style.display = 'none';
}

// Loading + Timer
document.getElementById('formCV').addEventListener('submit', function() {
    document.getElementById('cvLoadingOverlay').style.display = 'flex';
    document.getElementById('btnCV').disabled = true;
    let s = 0;
    setInterval(() => { s++; document.getElementById('cvTimer').textContent = s; }, 1000);
});
</script>
@endsection
