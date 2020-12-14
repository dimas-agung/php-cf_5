( function (window, document, $) {
	$(window).load( function () {

	});
	$(window).resize( function () {
		
	});
	$( function () {
		var
			$ariefId = function () {
				return {
					__construct: function () {
						$ariefId.listGroup();
					},
					__destruct: function () {
						
					},
					generateUuid4: function () {
						return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function ($c) {
							var 
								$r = Math.random() * 16 | 0, 
								$v = $c == 'x' ? $r : ($r & 0x3 | 0x8);
							return $v.toString(16);
						}); 
					},
					toBoolean: function ($string) { 
						var
							$string = ($string || '').toString().toLowerCase();
						if ($string !== '') {
							switch ($string) {
								case 'false':
								case 'no':
								case '0':
								case '':
									return false;
									break;
								default:
									return true;
									break;
							}
						}
					},
					listGroup: function () {
						var
							$listGroup = $('div[class*="list-group"]');
						if ($listGroup.length) {
							$listGroup.each( function ($index, $element) {
								$thisIndex = $($index),
								$thisElement = $($element);
								$thisElement.find('a').on('click', function ($clickElement) {
									$thisClickElement = $(this);
									$clickElement.preventDefault();
									$thisClickElement.tab('show');
									console.log($thisClickElement);
								});
							});
						}
					},
				};
			}();
		$ariefId.__construct();
	});
}(window, document, window.jQuery));