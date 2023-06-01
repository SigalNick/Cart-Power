{include file="common/header.tpl"}

<h1>{$product.product}</h1>

<form method="post" action="{url current}">
    <input type="hidden" name="product_id" value="{$product.product_id}">
    <div class="form-group">
        <label for="long_url">{__("long_url")}</label>
        <input type="text" class="form-control" id="long_url" name="long_url" value="{$product.url}" readonly>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{__("shorten_url")}</button>
    </div>
</form>

{include file="common/footer.tpl"}