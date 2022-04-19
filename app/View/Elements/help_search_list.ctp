<%
for(var item in data){
	var getdata = data[item];
	console.log(getdata);
%>
	<p>
		<a href="<%= getdata.link%>" target="_blank">
			<%= getdata.title%>
		</a>
		<p> <%= $(getdata.content).text().substr(0, 100) %>...</p>
	</p>
<%
}
%>