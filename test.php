<h4>Try it yourself</h4>
<form method=post action=oscxmlapi.php>
<textarea rows=20 cols=90 name=xmlDoc>
<xml>
	<login>
		<username>username</username>
		<password>password</password>
	</login>
	<update>
		<products>
			<product>
				<products_id>1</products_id>
				<products_quantity>10</products_quantity>
				<products_status>1</products_status>
			</product>
			<product>
				<products_id>2</products_id>
				<products_quantity>53</products_quantity>
				<products_status>2</products_status>
			</product>
			<product>
				<products_id>3</products_id>
				<products_quantity>0</products_quantity>
				<products_status>0</products_status>
			</product>
		</products>
	</update>
</xml>
</textarea>
<input type=submit value="Request">
</form>