<h4>Ranger JS API </h4>
<pre id="request" style="height:100%;">

</pre>
<pre id="response" style="height:100%;">

</pre>

<script>
    $(function(){
        $("#request").text(JSON.stringify({method:'ranger.article.list',query:{where:[['<','id',230]],page:1,page_size:2},params:{format:'json'}},null,"\t"));
        var response = Ranger.api.request('ranger.article.list',{where:[['<','id',230]],page:1,page_size:2},{format:'json'});
        $("#response").text(JSON.stringify(response,null,"\t"));
    })
</script>