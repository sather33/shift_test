<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>La Jolla Api Document</title>

	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h2>La Jolla Api Document <small>Api Base URL: {{ env('APP_URL') }}/api/</small></h2>
		<hr>
		<p><strong>＊ columns may not show if don't exist or not needed.</strong></p>
		<p><strong>＊ empty value come with <code>null</code></strong></p>
		<hr>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-homepage-data</code> 取得首頁資料</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
				<p>no input</p>
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-homepage-data</code></p>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-product-nav</code> 取得 nav 裡的 product dropdown 選項</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
				<p>no input</p>
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-product-nav</code></p>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-product-list</code> 取得商品列表資料，start 為 0 時會多帶入搜尋的選項、列表標題、列表廣告圖(如果有)</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> category    = { int | category_id | 商品類別 }
 series      = { int | series_id | 商品系列 }
 style       = { int | style_id | 款式系列 }
 price_range = { string | 0-5000 or 5000-10000 ... }
 color       = { int | color_id | 商品顏色 }
 material    = { int | material_id | 商品材質 }
 start       = { int | 商品開始的 index | 預設值為 0 }
 count       = { int | 需要的商品數量 | 預設值為 12 }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-product-list?category=1&start=12&count=6</code></p>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-product-data</code> 取得商品詳細頁資料</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> id = { int | product_id }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-product-data?id=1</code></p>
			</div>
		</div>
		
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-news-list</code> 取得最新消息列表資料，固定帶最新消息類別選項，不帶參數時為全部中文消息</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> category = { int or null | category_id | 最新消息類別 | 預設值為 null (表示全部消息)}
 lang     = { string | 'en' or 'zh' | 網頁語言 | 預設值為 'zh' }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-news-list?category=1&lang=en</code></p>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-news-data</code> 取得消息詳細頁資料</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> id = { int | news_id }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-news-data?id=1</code></p>
			</div>
		</div>
		
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">GET</h3>
				<p><code>get-warranty-product-categories-list</code> 取得保固申請表格產品類別選項</p>
				<p>＊選項的值為回傳裡面的 <code>value</code> 得值，不是 <code>id</code></p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
				<p>no input</p>	
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/get-warranty-product-categories-list</code></p>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">POST</h3>
				<p><code>post-store-warranty-data</code> 存入保固註冊資料</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> name             = { string | 姓名 | 必填、無最長限制 }
 mobile           = { string | 手機號碼 | 必填、最短 10 碼、最長 20 碼、接受數字及空白及+-符號 }
 email            = { string | 電子信箱 | 必填、必須是個 email }
 buy_date         = { string | 購買日期 | 必填、僅接受 YYYY-mm-dd 或 YYYY/mm/dd 2種格式 }
 buy_store        = { string | 購買地點 | 必填、最短 6 字元、最長 19 字元 (根據選項字數計算(含空白)) }
 product_name     = { stirng | 商品名稱 | 必填、無最長限制 }
 product_category = { string | 商品類別 | 必填、值為類別中文名稱 }
 invoice_img      = { file | 購買證明 | 必填、目前僅接受圖片，可討論是否增加其他檔案格式 }
 product_img      = { file | 商品照片 | 必填、僅接受圖片 }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/post-store-warranty-data</code></p>
<pre> Header:
 需要有 X-Requested-With=XMLHttpRequest

 Body:
 格式為 form-data</pre>
			</div>
		</div>
		
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">POST</h3>
				<p><code>post-store-contact-data</code> 存入聯絡我們資料</p>
			</div>
			<div class="panel-body">
				<h4>Input</h4>
<pre> name    = { string | 姓名 | 必填、無最長限制 }
 mobile  = { string | 手機號碼 | 必填、最短 10 碼、最長 20 碼、接受數字及空白及+-符號 }
 email   = { string | 電子信箱 | 必填、必須是個 email }
 img     = { file | 商品照片 | 非必填、僅接受圖片 }
 content = { string | 內容 | 必填、無最長限制 }</pre>
				
				<hr>
				<h4>Call Example</h4>
				<p><code>{{ env('APP_URL') }}/api/post-store-contact-data</code></p>
<pre> Header:
 需要有 X-Requested-With=XMLHttpRequest

 Body:
 格式為 form-data</pre>
			</div>
		</div>

	</div>

	<!-- jQuery CDN -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

	<!-- Bootstrap Js CDN -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>