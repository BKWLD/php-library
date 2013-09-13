<h1>Get an Instagram <a href="http://instagram.com/developer/authentication/">access token</a></h1>

<p>1. Register a "client" from Instagram's development portal.  The <code>redirect_uri</code> can just be the homepage (if so, make sure you add a trailing slash).</p>
<p>2. Make sure you have a valid /app/config/instagram.php file.</p>
<p>3. <a href="<?=$url?>">Authenticate into Instagram</a>.  When you are redirected back to this site, copy the <code>code</code> value that is passed in the GET params</p>
<form method="GET">
	4. Paste the "code"
	<input type="text" placeholder="here" name="code" />
	and then 
	<button type="submit">submit</button>
</form>

<? if (!empty($response)): ?>
	<h2>Here's what Instagram returned</h2>
	<pre><?print_r($response)?></pre>
<? endif ?>