<div class="form-group">
    <label>Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control" style="width: 100%;">
        <option value="0" @if(isset($categoryData['parent_id']) && $categoryData['parent_id'] == 0) selected="" @endif>Main Categories</option>
        @if (!empty($getCategories))
            @foreach ($getCategories as $cat)
                <option value="{{ $cat['id'] }}" @if(isset($categoryData['parent_id']) && $categoryData['parent_id'] == $cat['id']) selected @endif>{{ $cat['category_name'] }}</option>
                @if (!empty($cat['subcategories']))
                    @foreach ($cat['subcategories'] as $subcat)
                        <option value="{{ $subcat['id'] }}" @if(!empty($categoryData['parent_id']) && $categoryData['parent_id'] == $subcat['id']) selected @endif>&nbsp;&raquo;&nbsp;{{ $subcat['category_name'] }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>