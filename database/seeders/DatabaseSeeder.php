<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. Tạo tài khoản admin ===
        DB::table('nguoi_dung')->insert([
            ['ho_ten' => 'Admin', 'email' => 'admin@mbticrs.vn', 'mat_khau' => Hash::make('12345678'), 'vai_tro' => 'admin', 'trang_thai' => 'hoat_dong', 'tao_luc' => now(), 'cap_nhat_luc' => now()],
            ['ho_ten' => 'Nguyễn Văn A', 'email' => 'user@mbticrs.vn', 'mat_khau' => Hash::make('12345678'), 'vai_tro' => 'user', 'trang_thai' => 'hoat_dong', 'tao_luc' => now(), 'cap_nhat_luc' => now()],
        ]);

        // === 2. 16 kiểu MBTI ===
        $kieuMbti = [
            ['ISTJ','Nhà Hậu Cần','Người thực tế, có trách nhiệm và đáng tin cậy. Thích làm việc có kế hoạch rõ ràng.','Đáng tin cậy, kiên nhẫn, chi tiết, có trách nhiệm','Cứng nhắc, khó thích nghi, ít linh hoạt','Có tổ chức, tuân thủ quy tắc, làm việc độc lập','Môi trường có cấu trúc, ổn định','Warren Buffett, Nữ hoàng Elizabeth II'],
            ['ISFJ','Người Bảo Vệ','Người tận tâm, ấm áp và có trách nhiệm. Luôn sẵn sàng giúp đỡ người khác.','Tận tụy, kiên nhẫn, đáng tin cậy, quan sát tốt','Hay lo lắng, khó từ chối, ít bộc lộ','Cẩn thận, hỗ trợ đồng nghiệp','Môi trường hài hòa, ổn định','Beyoncé, Kate Middleton'],
            ['INFJ','Người Che Chở','Người lý tưởng, sâu sắc và kiên quyết. Luôn tìm kiếm ý nghĩa trong mọi việc.','Sáng tạo, sâu sắc, kiên quyết, có tầm nhìn','Cầu toàn, nhạy cảm, khó hòa nhập','Tập trung vào mục tiêu dài hạn','Môi trường yên tĩnh, có ý nghĩa','Martin Luther King Jr., Nelson Mandela'],
            ['INTJ','Nhà Chiến Lược','Người tư duy độc lập, có chiến lược và tham vọng. Giỏi lập kế hoạch dài hạn.','Chiến lược, độc lập, logic, sáng tạo','Kiêu ngạo, ít cảm xúc, cầu toàn, khó hợp tác','Hiệu quả, tự chủ, hướng mục tiêu','Môi trường thách thức trí tuệ','Elon Musk, Mark Zuckerberg'],
            ['ISTP','Thợ Thủ Công','Người thực tế, linh hoạt và quan sát tốt. Thích khám phá cơ chế hoạt động.','Linh hoạt, thực tế, giải quyết vấn đề, bình tĩnh','Khó giao tiếp, liều lĩnh, ít cam kết','Thích thử nghiệm, làm việc tay chân','Môi trường linh hoạt, thực hành','Bruce Lee, Michael Jordan'],
            ['ISFP','Nghệ Sĩ','Người nhạy cảm, tử tế và sáng tạo. Sống theo cảm xúc và giá trị cá nhân.','Sáng tạo, thân thiện, nhạy cảm, linh hoạt','Dễ bị tổn thương, tránh xung đột, khó lập kế hoạch','Tự do sáng tạo, ít gò bó','Môi trường nghệ thuật, tự do','Bob Marley, Frida Kahlo'],
            ['INFP','Người Hòa Giải','Người lý tưởng, sáng tạo và nhạy cảm. Luôn tìm kiếm sự hài hòa.','Sáng tạo, cảm thông, kiên quyết với giá trị','Quá lý tưởng, nhạy cảm, khó thực tế','Sáng tạo, tập trung vào giá trị','Môi trường nhân văn, sáng tạo','William Shakespeare, Johnny Depp'],
            ['INTP','Nhà Logic','Người phân tích, sáng tạo và logic. Thích giải quyết các vấn đề phức tạp.','Logic, sáng tạo, phân tích, khách quan','Lơ đãng, khó giao tiếp, hay trì hoãn','Nghiên cứu, phân tích, làm việc độc lập','Môi trường học thuật, nghiên cứu','Albert Einstein, Bill Gates'],
            ['ESTP','Nhà Kinh Doanh','Người năng động, thực tế và thích phiêu lưu. Hành động nhanh, quyết đoán.','Năng động, thực tế, quyết đoán, xã giao','Bốc đồng, thiếu kiên nhẫn, liều lĩnh','Hành động nhanh, thích thách thức','Môi trường năng động, cạnh tranh','Donald Trump, Madonna'],
            ['ESFP','Nghệ Sĩ Biểu Diễn','Người vui vẻ, năng động và thích giao tiếp. Yêu thích cuộc sống.','Vui vẻ, năng động, thân thiện, linh hoạt','Thiếu tập trung, tránh xung đột, ít kiên nhẫn','Sáng tạo, hợp tác, năng động','Môi trường vui vẻ, xã hội','Marilyn Monroe, Jamie Oliver'],
            ['ENFP','Người Truyền Cảm Hứng','Người nhiệt huyết, sáng tạo và lạc quan. Giỏi truyền cảm hứng cho người khác.','Sáng tạo, nhiệt huyết, giao tiếp tốt, linh hoạt','Khó tập trung, quá lạc quan, hay thay đổi','Sáng tạo, truyền cảm hứng','Môi trường linh hoạt, sáng tạo','Robin Williams, Robert Downey Jr.'],
            ['ENTP','Nhà Tranh Luận','Người thông minh, sáng tạo và thích thách thức. Giỏi tranh luận.','Sáng tạo, thông minh, năng động, nhạy bén','Hay tranh cãi, thiếu kiên nhẫn, khó tuân thủ','Đổi mới, thích thách thức','Môi trường đổi mới, tự do','Thomas Edison, Benjamin Franklin'],
            ['ESTJ','Người Điều Hành','Người có tổ chức, quyết đoán và đáng tin cậy. Giỏi quản lý.','Có tổ chức, quyết đoán, đáng tin cậy, thực tế','Cứng nhắc, ít linh hoạt, hay phán xét','Quản lý, tổ chức, dẫn dắt','Môi trường có cấu trúc, rõ ràng','Henry Ford, Sonia Sotomayor'],
            ['ESFJ','Người Chăm Sóc','Người ấm áp, tận tụy và có trách nhiệm. Thích giúp đỡ cộng đồng.','Tận tụy, ấm áp, có trách nhiệm, hợp tác','Nhạy cảm, hay lo lắng, cần được công nhận','Hỗ trợ, hợp tác, phục vụ','Môi trường hài hòa, đoàn kết','Taylor Swift, Jennifer Garner'],
            ['ENFJ','Người Dẫn Dắt','Người lãnh đạo bẩm sinh, đồng cảm và truyền cảm hứng.','Lãnh đạo, đồng cảm, truyền cảm hứng','Quá hy sinh, nhạy cảm, khó nói không','Dẫn dắt, truyền cảm hứng, hợp tác','Môi trường hợp tác, có ý nghĩa','Barack Obama, Oprah Winfrey'],
            ['ENTJ','Nhà Chỉ Huy','Người lãnh đạo mạnh mẽ, quyết đoán và chiến lược. Thích thách thức và dẫn dắt.','Lãnh đạo, chiến lược, quyết đoán, hiệu quả','Áp đặt, thiếu kiên nhẫn, ít cảm thông','Chiến lược, dẫn dắt, tối ưu hóa','Môi trường cạnh tranh, thách thức','Steve Jobs, Gordon Ramsay'],
        ];

        foreach ($kieuMbti as $km) {
            DB::table('kieu_mbti')->insert([
                'ma_kieu' => $km[0], 'ten_goi' => $km[1], 'mo_ta_chung' => $km[2],
                'diem_manh' => $km[3], 'diem_yeu' => $km[4], 'phong_cach_lam_viec' => $km[5],
                'moi_truong_phu_hop' => $km[6], 'nguoi_noi_tieng' => $km[7],
                'tao_luc' => now(), 'cap_nhat_luc' => now(),
            ]);
        }

        // === 3. Lĩnh vực ===
        $linhVuc = ['Công nghệ thông tin', 'Y tế & Sức khỏe', 'Giáo dục', 'Kinh doanh & Tài chính', 'Nghệ thuật & Thiết kế', 'Kỹ thuật & Công nghệ', 'Luật & Chính sách', 'Truyền thông & Marketing'];
        foreach ($linhVuc as $lv) {
            DB::table('linh_vuc')->insert(['ten_linh_vuc' => $lv, 'tao_luc' => now(), 'cap_nhat_luc' => now()]);
        }

        // === 4. Nghề nghiệp mẫu ===
        $ngheNghiep = [
            ['Lập trình viên', 1, 15000000, 45000000], ['Nhà khoa học dữ liệu', 1, 20000000, 60000000],
            ['Bác sĩ', 2, 15000000, 50000000], ['Giáo viên', 3, 8000000, 20000000],
            ['Kế toán', 4, 10000000, 25000000], ['Nhà thiết kế UI/UX', 5, 12000000, 35000000],
            ['Kiến trúc sư', 6, 15000000, 40000000], ['Luật sư', 7, 15000000, 50000000],
            ['Chuyên viên Marketing', 8, 10000000, 30000000], ['Quản lý dự án', 4, 20000000, 50000000],
        ];
        foreach ($ngheNghiep as $nn) {
            DB::table('nghe_nghiep')->insert([
                'ten_nghe' => $nn[0], 'linh_vuc_id' => $nn[1],
                'muc_luong_min' => $nn[2], 'muc_luong_max' => $nn[3],
                'trang_thai' => 'hien', 'tao_luc' => now(), 'cap_nhat_luc' => now(),
            ]);
        }

        // === 5. Câu hỏi MBTI (70 câu, mỗi nhóm ~17-18 câu) ===
        $cauHoi = [
            // ========== EI (1-18) ==========
            ['Khi tham gia buổi tiệc, bạn thường:', 'Nói chuyện với nhiều người, kể cả người lạ', 'Chỉ nói chuyện với vài người quen', 'EI', 1],
            ['Sau một ngày làm việc mệt mỏi, bạn thích:', 'Đi chơi với bạn bè để xả stress', 'Ở nhà một mình để nạp năng lượng', 'EI', 2],
            ['Trong lớp học, bạn thường:', 'Chủ động phát biểu và thảo luận', 'Lắng nghe và suy nghĩ trước khi nói', 'EI', 3],
            ['Bạn cảm thấy thoải mái hơn khi:', 'Làm việc nhóm, trao đổi ý tưởng', 'Làm việc một mình, tập trung cao', 'EI', 4],
            ['Khi gặp người mới, bạn thường:', 'Chủ động bắt chuyện, giới thiệu bản thân', 'Chờ đợi người khác nói chuyện trước', 'EI', 5],
            ['Cuối tuần lý tưởng của bạn là:', 'Đi picnic, tụ họp bạn bè hoặc tham gia sự kiện', 'Ở nhà đọc sách, xem phim hoặc làm việc cá nhân', 'EI', 6],
            ['Khi cần ra quyết định, bạn thường:', 'Hỏi ý kiến nhiều người xung quanh', 'Tự suy nghĩ kỹ rồi mới quyết định', 'EI', 7],
            ['Bạn thích học tập bằng cách:', 'Thảo luận nhóm, trao đổi với bạn', 'Đọc tài liệu một mình, tự ghi chép', 'EI', 8],
            ['Khi có tin vui, bạn thường:', 'Chia sẻ ngay với nhiều người', 'Chỉ kể với vài người thân nhất', 'EI', 9],
            ['Ở nơi làm việc, bạn thích:', 'Không gian mở, giao tiếp nhiều', 'Phòng riêng, yên tĩnh để tập trung', 'EI', 10],
            ['Khi buồn, bạn thường:', 'Tìm bạn bè để tâm sự, chia sẻ', 'Muốn ở một mình để suy nghĩ', 'EI', 11],
            ['Về số lượng bạn bè:', 'Bạn có rất nhiều bạn ở các nhóm khác nhau', 'Bạn có ít bạn nhưng rất thân thiết', 'EI', 12],
            ['Khi trình bày ý tưởng:', 'Bạn nghĩ ra ý tưởng khi nói chuyện với người khác', 'Bạn cần thời gian suy nghĩ trước khi trình bày', 'EI', 13],
            ['Giờ nghỉ trưa, bạn thích:', 'Ngồi ăn cùng đồng nghiệp, trò chuyện', 'Ăn một mình hoặc đi dạo yên tĩnh', 'EI', 14],
            ['Khi tham gia hội thảo:', 'Bạn thích phần giao lưu, networking', 'Bạn thích phần nội dung chuyên môn', 'EI', 15],
            ['Cách bạn nạp năng lượng:', 'Gặp gỡ bạn bè, tham gia hoạt động xã hội', 'Dành thời gian cho bản thân, nghỉ ngơi', 'EI', 16],
            ['Trong một nhóm dự án lớn:', 'Bạn muốn là người điều phối, liên lạc', 'Bạn muốn phụ trách phần việc cá nhân', 'EI', 17],
            ['Khi ở trong phòng chờ:', 'Bạn dễ dàng bắt chuyện với người lạ', 'Bạn chờ im lặng và xem điện thoại', 'EI', 18],

            // ========== SN (19-35) ==========
            ['Khi đọc sách, bạn thích:', 'Sách hướng dẫn thực tế, có ví dụ cụ thể', 'Sách lý thuyết, triết lý, ý tưởng mới', 'SN', 19],
            ['Khi giải quyết vấn đề, bạn dựa vào:', 'Kinh nghiệm thực tế đã có', 'Trực giác và linh cảm của mình', 'SN', 20],
            ['Bạn thường chú ý đến:', 'Chi tiết cụ thể, dữ kiện thực tế', 'Bức tranh tổng thể, xu hướng', 'SN', 21],
            ['Khi nghe ai kể chuyện, bạn quan tâm:', 'Sự kiện đã xảy ra (ai, ở đâu, khi nào)', 'Ý nghĩa và bài học đằng sau câu chuyện', 'SN', 22],
            ['Bạn thích làm việc với:', 'Dữ liệu thực tế, con số cụ thể', 'Ý tưởng mới, khả năng tương lai', 'SN', 23],
            ['Khi mô tả một sự vật:', 'Bạn nói chính xác: kích thước, hình dạng, màu sắc', 'Bạn dùng ví von, so sánh với thứ khác', 'SN', 24],
            ['Khi học một kỹ năng mới:', 'Bạn làm theo từng bước hướng dẫn cụ thể', 'Bạn thích hiểu nguyên lý tổng quát trước', 'SN', 25],
            ['Trong môn lịch sử, bạn thích:', 'Nhớ ngày tháng, sự kiện cụ thể', 'Phân tích nguyên nhân và tác động lịch sử', 'SN', 26],
            ['Bạn tin tưởng hơn vào:', 'Bằng chứng thực tế, dữ liệu đo lường được', 'Linh cảm, cảm nhận cá nhân', 'SN', 27],
            ['Khi lập kế hoạch cho dự án:', 'Bạn liệt kê chi tiết từng bước thực hiện', 'Bạn vẽ ra tầm nhìn tổng thể trước', 'SN', 28],
            ['Câu hỏi bạn thường đặt ra:', 'Điều này hoạt động như thế nào?', 'Tại sao điều này lại xảy ra?', 'SN', 29],
            ['Khi nấu ăn, bạn thường:', 'Làm theo công thức chính xác', 'Tự sáng tạo, thử nghiệm nguyên liệu mới', 'SN', 30],
            ['Về tương lai:', 'Bạn tập trung vào hiện tại, việc trước mắt', 'Bạn hay mơ về tương lai, khả năng mới', 'SN', 31],
            ['Bạn ấn tượng hơn với:', 'Người làm việc chính xác, cẩn thận', 'Người có ý tưởng sáng tạo, đột phá', 'SN', 32],
            ['Khi viết báo cáo:', 'Bạn trình bày dữ kiện, số liệu rõ ràng', 'Bạn phân tích xu hướng, đề xuất ý tưởng mới', 'SN', 33],
            ['Khi giao tiếp, bạn:', 'Nói rõ ràng, đúng trọng tâm', 'Nói xa xôi, dùng nhiều phép ẩn dụ', 'SN', 34],
            ['Bạn giỏi hơn trong việc:', 'Ghi nhớ chi tiết sự kiện đã xảy ra', 'Tưởng tượng ra các kịch bản tương lai', 'SN', 35],

            // ========== TF (36-52) ==========
            ['Khi đưa ra quyết định quan trọng, bạn:', 'Phân tích logic, cân nhắc ưu nhược điểm', 'Lắng nghe cảm xúc, xem xét tác động đến mọi người', 'TF', 36],
            ['Khi bạn bè mắc lỗi, bạn thường:', 'Chỉ ra lỗi sai một cách thẳng thắn', 'Động viên trước, rồi nhẹ nhàng góp ý', 'TF', 37],
            ['Trong tranh luận, bạn:', 'Bảo vệ quan điểm dựa trên logic', 'Cố gắng giữ hòa khí, tránh xung đột', 'TF', 38],
            ['Bạn đánh giá người khác dựa trên:', 'Năng lực và kết quả công việc', 'Thái độ và cách đối xử với mọi người', 'TF', 39],
            ['Khi phải chọn giữa công bằng và nhân hậu:', 'Chọn công bằng, dù có người không vui', 'Chọn nhân hậu, quan tâm đến cảm xúc mọi người', 'TF', 40],
            ['Khi bị phê bình:', 'Bạn xem xét phê bình đó có logic không', 'Bạn cảm thấy tổn thương, bất dù phê bình đúng', 'TF', 41],
            ['Với một nhân viên làm việc kém:', 'Bạn đánh giá dựa trên kết quả, nói thẳng', 'Bạn tìm hiểu hoàn cảnh, hỗ trợ cải thiện', 'TF', 42],
            ['Khi xem một bộ phim buồn:', 'Bạn phân tích cốt truyện, nhân vật', 'Bạn dễ xúc động, đồng cảm với nhân vật', 'TF', 43],
            ['Đối với bạn, thành công nghĩa là:', 'Đạt được mục tiêu, có thành tích cụ thể', 'Sống hạnh phúc, có ý nghĩa với mọi người', 'TF', 44],
            ['Khi chọn quà tặng:', 'Bạn chọn thứ thiết thực, có ích', 'Bạn chọn thứ có ý nghĩa cảm xúc', 'TF', 45],
            ['Trong cuộc họp, bạn:', 'Tập trung vào hiệu quả, kết quả cuộc họp', 'Quan tâm đến bầu không khí, cảm xúc mọi người', 'TF', 46],
            ['Khi bạn thân và đồng nghiệp xung đột:', 'Bạn phân tích ai đúng ai sai', 'Bạn cố gắng hòa giải, vì cả hai đều quan trọng', 'TF', 47],
            ['Bạn nghĩ sự thật:', 'Quan trọng hơn cảm xúc', 'Cần nói đúng lúc, đúng cách để không làm tổn thương', 'TF', 48],
            ['Khi có mâu thuẫn trong nhóm:', 'Bạn muốn giải quyết bằng lý lẽ, logic', 'Bạn muốn mọi người thấu hiểu nhau hơn', 'TF', 49],
            ['Bạn tự hào vì:', 'Bạn luôn công bằng và khách quan', 'Bạn luôn biết quan tâm và thấu hiểu', 'TF', 50],
            ['Khi đánh giá một quyết định:', 'Bạn hỏi: Đây có phải là quyết định đúng?', 'Bạn hỏi: Quyết định này ảnh hưởng đến ai?', 'TF', 51],
            ['Khi phải sa thải nhân viên:', 'Bạn dựa trên hiệu suất, đưa ra quyết định lý trí', 'Bạn rất khó khăn vì lo lắng cho cuộc sống của họ', 'TF', 52],

            // ========== JP (53-70) ==========
            ['Bạn thích lên kế hoạch:', 'Chi tiết trước khi làm', 'Linh hoạt, tùy cơ ứng biến', 'JP', 53],
            ['Deadline đến gần, bạn thường:', 'Đã hoàn thành từ trước', 'Hoàn thành vào phút chót nhưng vẫn ổn', 'JP', 54],
            ['Bàn làm việc của bạn:', 'Gọn gàng, ngăn nắp', 'Hơi lộn xộn nhưng bạn biết mọi thứ ở đâu', 'JP', 55],
            ['Khi đi du lịch, bạn thích:', 'Có lịch trình rõ ràng', 'Đi tự do, khám phá ngẫu hứng', 'JP', 56],
            ['Quy tắc trong cuộc sống:', 'Rất quan trọng, giúp mọi thứ có trật tự', 'Có thể linh hoạt thay đổi khi cần', 'JP', 57],
            ['Khi mua sắm, bạn:', 'Lập danh sách trước, mua đúng nhu cầu', 'Xem có gì hay thì mua, không cần danh sách', 'JP', 58],
            ['Với công việc hàng ngày:', 'Bạn thích có lịch làm việc rõ ràng', 'Bạn thích linh hoạt, không bị bó buộc', 'JP', 59],
            ['Khi có sự thay đổi kế hoạch bất ngờ:', 'Bạn cảm thấy khó chịu, stress', 'Bạn thấy thú vị, có thể thích ứng nhanh', 'JP', 60],
            ['Về thói quen cá nhân:', 'Bạn thích duy trì thói quen ổn định', 'Bạn thích thay đổi, thử điều mới', 'JP', 61],
            ['Khi bắt đầu dự án mới:', 'Bạn lập kế hoạch chi tiết trước khi bắt đầu', 'Bạn bắt đầu làm ngay và điều chỉnh dần', 'JP', 62],
            ['Bạn cảm thấy thoải mái hơn khi:', 'Mọi thứ đã được quyết định rõ ràng', 'Vẫn còn nhiều lựa chọn mở', 'JP', 63],
            ['Về giờ giấc:', 'Bạn luôn đúng giờ hoặc đến sớm', 'Bạn đến linh hoạt, đôi khi muộn vài phút', 'JP', 64],
            ['Khi chuẩn bị cho kỳ thi:', 'Bạn ôn tập theo kế hoạch từ đầu', 'Bạn ôn dồn vào cuối, nhưng vẫn hiệu quả', 'JP', 65],
            ['Bạn thích hoàn thành công việc:', 'Trước hạn, để yên tâm', 'Gần deadline, vì áp lực giúp bạn hiệu quả hơn', 'JP', 66],
            ['Danh sách việc cần làm:', 'Bạn luôn có và tuân theo nó', 'Bạn hiếm khi liệt kê, thích làm tự nhiên', 'JP', 67],
            ['Khi chọn nhà hàng ăn tối:', 'Bạn đặt bàn trước, chọn menu sẵn', 'Bạn đi lang thang, thấy quán nào ổn thì vào', 'JP', 68],
            ['Với email và tin nhắn:', 'Bạn trả lời ngay, sắp xếp hộp thư gọn gàng', 'Bạn trả lời khi nào tiện, hộp thư hơi lộn xộn', 'JP', 69],
            ['Bạn muốn cuộc sống:', 'Có trật tự, ổn định, dự đoán được', 'Đầy bất ngờ, linh hoạt, tự do', 'JP', 70],
        ];

        $chieuMap = ['EI' => ['E','I'], 'SN' => ['S','N'], 'TF' => ['T','F'], 'JP' => ['J','P']];
        foreach ($cauHoi as $cau) {
            $chieu = $chieuMap[$cau[3]];
            DB::table('cau_hoi')->insert([
                'noi_dung' => $cau[0], 'lua_chon_a' => $cau[1], 'lua_chon_b' => $cau[2],
                'chieu_a' => $chieu[0], 'chieu_b' => $chieu[1], 'nhom_chieu' => $cau[3],
                'thu_tu' => $cau[4], 'trang_thai' => 'hoat_dong', 'tao_luc' => now(), 'cap_nhat_luc' => now(),
            ]);
        }

        // === 6. Liên kết nghề nghiệp - MBTI ===
        // Lấy ID kiểu MBTI
        $kieuIds = DB::table('kieu_mbti')->pluck('id', 'ma_kieu')->toArray();
        $ngheIds = DB::table('nghe_nghiep')->pluck('id', 'ten_nghe')->toArray();

        // Liên kết: [tên_nghề => [kiểu_mbti => mức_phù_hợp]]
        $lienKet = [
            'Lập trình viên' => ['INTJ'=>'rat_cao','INTP'=>'rat_cao','ISTJ'=>'cao','ISTP'=>'cao','ENTJ'=>'cao'],
            'Nhà khoa học dữ liệu' => ['INTJ'=>'rat_cao','INTP'=>'rat_cao','ENTJ'=>'cao','ISTJ'=>'cao'],
            'Bác sĩ' => ['ISFJ'=>'rat_cao','ISTJ'=>'rat_cao','INFJ'=>'cao','ESFJ'=>'cao','ENFJ'=>'cao'],
            'Giáo viên' => ['ENFJ'=>'rat_cao','INFJ'=>'rat_cao','ESFJ'=>'cao','ISFJ'=>'cao','ENFP'=>'cao'],
            'Kế toán' => ['ISTJ'=>'rat_cao','ESTJ'=>'rat_cao','ISFJ'=>'cao','INTJ'=>'trung_binh'],
            'Nhà thiết kế UI/UX' => ['ISFP'=>'rat_cao','INFP'=>'rat_cao','ENFP'=>'cao','INTP'=>'cao'],
            'Kiến trúc sư' => ['INTJ'=>'rat_cao','INTP'=>'cao','ISFP'=>'cao','ENTJ'=>'trung_binh'],
            'Luật sư' => ['ENTJ'=>'rat_cao','INTJ'=>'rat_cao','ESTJ'=>'cao','ENTP'=>'cao'],
            'Chuyên viên Marketing' => ['ENFP'=>'rat_cao','ENTP'=>'rat_cao','ESFP'=>'cao','ESTP'=>'cao','ENFJ'=>'cao'],
            'Quản lý dự án' => ['ENTJ'=>'rat_cao','ESTJ'=>'rat_cao','ENFJ'=>'cao','INTJ'=>'cao'],
        ];

        foreach ($lienKet as $tenNghe => $kieuList) {
            if (!isset($ngheIds[$tenNghe])) continue;
            foreach ($kieuList as $maKieu => $mucDo) {
                if (!isset($kieuIds[$maKieu])) continue;
                DB::table('nghe_nghiep_mbti')->insert([
                    'nghe_nghiep_id' => $ngheIds[$tenNghe],
                    'kieu_mbti_id' => $kieuIds[$maKieu],
                    'muc_do_phu_hop' => $mucDo,
                ]);
            }
        }
    }
}
