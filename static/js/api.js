var API = {
	invokeModuleCall:function(host_url, module,fun,param,callback) {
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