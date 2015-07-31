<script type="text/javascript">
		var i = 1;
		Function.prototype.functionName = function ()
		{
			var name = /\W*function\s*([\w$]+)/.exec(this);
			return name ? name[1] : 'Anonymous';
		};

		function helloWorld() {
			alert('Hello from the ' + arguments.callee.functionName() + '() function!');
		}

//		function deneme() {
//			alert("123");
//		};
//
//		deneme(1, 2, 3, 4, 5, 6);
//helloWorld(); //displays "Hello from the helloWorld() function!"

//a better way that reuses the existing functionality
console.log([1,2,3,4,5].join());
Array.prototype.join = (function (originalJoin) {
        return function (separator) {
            console.log(separator);
                return originalJoin.call(this, separator === undefined ? '|' : separator);
        };
})(Array.prototype.join);
console.log([1,2,3,4,5].join());

</script>
