<template>
    <div class="form-group">
        <label>Result Type:</label>
        <select class="select2" name="categories" multiple="multiple" data-placeholder="Any" style="width: 100%;">
            <option>Text only</option>
            <option>Images</option>
            <option>Video</option>
        </select>
    </div>
<div class="row">
    <div class="col-6">
      <div class="form-group">
        <label>Price Order:</label>
        <select class="form-control">
          <option value="asc">ASC</option>
          <option value="desc">DESC</option>
        </select>
      </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Date Order:</label>
            <select class="form-control">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
    </div>
</div>
</template>

<script>
export default{
    mounted(){
        $('.select2').select2();
    }
}
</script>