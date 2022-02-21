<form action="javascript:void(0)" method="post" id="admin-category-add">
    <h3>Thêm danh mục mới</h3>
    <div id="admin-category-add-status"></div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="input-box">
                <label for="admin-category-add-name">Tên danh mục</label>
                <input id="admin-category-add-name" type="text" placeholder="Tên danh mục" value="">
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-box">
                <label for="admin-category-add-parent">Là con của danh mục</label>
                <select id="admin-category-add-parent">
                    <option value="0">----</option>
                </select>
            </div>
        </div>
    </div>
    <div class="btn-box">
        <button type="submit" id="admin-category-add-btn">Thêm</button>
    </div>
</form>


<form action="javascript:void(0)" method="post" id="admin-category-edit">
    <h3>Chỉnh sửa danh mục</h3>
    <br>
    <div id="admin-category-edit-status"></div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-category-edit-name">Tên danh mục</label>
                <input id="admin-category-edit-name" type="text" placeholder="Tên danh mục" value="">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-category-edit-parent">Là con của danh mục</label>
                <select id="admin-category-edit-parent">
                    <option value="0">----</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-category-edit-index">Vị trí</label>
                <input id="admin-category-edit-index" type="text" placeholder="Vị trí" value="1">
            </div>
        </div>
    </div>
    <div class="btn-box">
        <button type="submit" id="admin-category-edit-submit-btn" data-id="">Cập nhật</button>
        &nbsp;&nbsp;
        <button type="submit" id="admin-category-edit-close-btn" data-id="">Đóng</button>
    </div>
</form>

<div id="admin-category-list">
    <h3>Danh sách danh mục</h3>
    <div id="admin-category-list-content">----</div>
</div>