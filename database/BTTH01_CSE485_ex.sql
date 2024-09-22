select * from baiviet
-- a Liệt kê các bài viết về các bài hát thuộc thể loại Nhạc trữ tình (2 đ) 
select baiviet.*
from baiviet
inner join theloai on baiviet.ma_tloai = theloai.ma_tloai
where theloai.ten_tloai = 'nhạc trữ tình'

--b Liệt kê các bài viết của tác giả “Nhacvietplus”
select baiviet.*
from baiviet
inner join tacgia on baiviet.ma_tgia = tacgia.ma_tgia
where tacgia.ten_tgia = 'Nhacvietplus'

--c Liệt kê các thể loại nhạc chưa có bài viết cảm nhận nào.
select *
from theloai
where ma_tloai not in (select distinct ma_tloai from baiviet);
--d Liệt kê các bài viết với các thông tin sau: mã bài viết, tên bài viết, tên bài hát, tên tác giả, tên thể loại, ngày viết.

select baiviet.ma_bviet,baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, 
theloai.ten_tloai, baiviet.ngayviet
from tacgia
inner join baiviet 
on tacgia.ma_tgia = baiviet.ma_tgia inner join theloai on baiviet.ma_tloai = theloai.ma_tloai
--e Tìm thể loại có số bài viết nhiều nhất
select top 1 theloai.ten_tloai, count(baiviet.ma_bviet) as so_bviet
from theloai
left join baiviet on theloai.ma_tloai = baiviet.ma_tloai
group by theloai.ten_tloai
order by so_bviet desc;

--f Liệt kê 2 tác giả có số bài viết nhiều nhất 
select top 2 tacgia.ten_tgia, count(baiviet.ma_bviet) as so_bviet
from tacgia
join baiviet on tacgia.ma_tgia = baiviet.ma_tgia
group by tacgia.ten_tgia
order by so_bviet desc
--Liệt kê các bài viết về các bài hát có tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”
select * 
from baiviet
where ten_bhat like '%yêu%' or ten_bhat like '%thương%' or ten_bhat like '%anh%' or ten_bhat like '%em%'

-- Liệt kê các bài viết về các bài hát có tiêu đề bài viết hoặc tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”:

select *
from baiviet
where tieude like '%yêu%' or ten_bhat like '%yêu%' or tieude like '%thương%' or ten_bhat like '%thương%'
or tieude like '%anh%' or ten_bhat like '%anh%' or tieude like '%em%' or ten_bhat like '%em%'

-- Tạo 1 view có tên vw_Music để hiển thị thông tin về Danh sách các bài viết kèm theo Tên thể loại và tên tác giả
create view vw_Music as
select 
    baiviet.ma_bviet,
    baiviet.tieude,
    baiviet.ten_bhat,
    theloai.ten_tloai,
    tacgia.ten_tgia,
    baiviet.tomtat,
    baiviet.noidung,
    baiviet.ngayviet,
    baiviet.hinhanh
from baiviet
join
    theloai on baiviet.ma_tloai = theloai.ma_tloai
join
    tacgia on baiviet.ma_tgia = tacgia.ma_tgia;

--Tạo 1 thủ tục có tên sp_DSBaiViet với tham số truyền vào là Tên thể loại và trả về danh sách Bài viết của thể loại đó. Nếu thể loại không tồn tại thì hiển thị thông báo lỗi. 
create procedure sp_dsbaiviet
    @tentheloai nvarchar(50)
as
begin
    -- kiểm tra nếu thể loại tồn tại
    if not exists (select 1 from theloai where lower(ten_tloai) = lower(@tentheloai))
    begin
        -- nếu thể loại không tồn tại, hiển thị thông báo lỗi
        raiserror('Thể loại không tồn tại', 16, 1);
        return;
    end

    -- nếu thể loại tồn tại, trả về danh sách bài viết
    select 
        baiviet.ma_bviet,
        baiviet.tieude,
        baiviet.ten_bhat,
        theloai.ten_tloai,
        tacgia.ten_tgia,
        baiviet.tomtat,
        baiviet.ngayviet,
        baiviet.hinhanh
    from 
        baiviet
    inner join 
        theloai on baiviet.ma_tloai = theloai.ma_tloai
    inner join 
        tacgia on baiviet.ma_tgia = tacgia.ma_tgia
    where 
        lower(theloai.ten_tloai) = lower(@tentheloai);
end;
--Thêm mới cột SLBaiViet vào trong bảng theloai. Tạo 1 trigger có tên tg_CapNhatTheLoai để khi thêm/sửa/xóa bài viết thì số lượng bài viết trong bảng theloai được cập nhật theo.
ALTER TABLE theloai ADD SLBaiViet int DEFAULT 0;

CREATE TRIGGER tg_CapNhatTheLoai
ON baiviet
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    -- Cập nhật số lượng bài viết khi có INSERT
    IF EXISTS (SELECT * FROM inserted)
    BEGIN
        UPDATE theloai
        SET SLBaiViet = (
            SELECT COUNT(*)
            FROM baiviet
            WHERE baiviet.ma_tloai = theloai.ma_tloai
        )
        WHERE theloai.ma_tloai IN (SELECT ma_tloai FROM inserted);
    END

    -- Cập nhật số lượng bài viết khi có DELETE
    IF EXISTS (SELECT * FROM deleted)
    BEGIN
        UPDATE theloai
        SET SLBaiViet = (
            SELECT COUNT(*)
            FROM baiviet
            WHERE baiviet.ma_tloai = theloai.ma_tloai
        )
        WHERE theloai.ma_tloai IN (SELECT ma_tloai FROM deleted);
    END
END;
--Bổ sung thêm bảng Users để lưu thông tin Tài khoản đăng nhập và sử dụng cho chức năng Đăng nhập/Quản trị trang web. 
create table Users (
    user_id INT PRIMARY KEY IDENTITY(1,1), -- Tự động tăng user_id
    username NVARCHAR(50) NOT NULL UNIQUE, -- Tên đăng nhập phải là duy nhất
    password NVARCHAR(255) NOT NULL, -- Mật khẩu đã được mã hóa
    email NVARCHAR(100) NOT NULL UNIQUE, -- Email phải là duy nhất
    role NVARCHAR(20) DEFAULT 'user', -- Vai trò (user/admin)
    created_at DATETIME DEFAULT GETDATE(), -- Thời gian tạo tài khoản
    last_login DATETIME -- Thời gian đăng nhập gần nhất
);
