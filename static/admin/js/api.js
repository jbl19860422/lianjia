var API = {
	invokeSyncCall:function(host_url,module,call_fun, param, succeed_callback) {
		$.ajax({ 
        type : "post", 
        url : host_url+"/"+module+"/"+call_fun, 
        data : param,
        async : false, 
        dataType:'json',
        success : succeed_callback
    }); 
	},
	invokeModuleCall:function(host_url,module,fun,param,callback) {
		$.post(
				host_url+"/"+module+"/"+fun,
				param,
				function(json) {
					callback(json);
				},
				"json"
		);
	}
};