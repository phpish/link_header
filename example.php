<?php

	require 'link_header.php';
	use phpish\link_header;


	// RFC 5988 examples (http://tools.ietf.org/html/rfc5988#section-5.5):

	print_r(link_header\parse('<http://example.com/TheBook/chapter2>; rel="previous"; title="previous chapter"'));

		/*
		Array
		(
			[previous] => Array
				(
					[uri] => http://example.com/TheBook/chapter2
					[rel] => previous
					[title] => previous chapter
				)

		)
		*/

	print_r(link_header\parse('</>; rel="http://example.net/foo"'));

		/*
		Array
		(
			[http://example.net/foo] => Array
				(
					[uri] => /
					[rel] => http://example.net/foo
				)

		)
		*/

	print_r(link_header\parse('</TheBook/chapter2>; rel="previous"; title*=UTF-8\'de\'letztes%20Kapitel, </TheBook/chapter4>; rel="next"; title*=UTF-8\'de\'n%c3%a4chstes%20Kapitel'));

		/*
		Array
		(
			[previous] => Array
				(
					[uri] => /TheBook/chapter2
					[rel] => previous
					[title*] => TF-8'de'letztes%20Kapitel
				)

			[next] => Array
				(
					[uri] => /TheBook/chapter4
					[rel] => next
					[title*] => TF-8'de'n%c3%a4chstes%20Kapitel
				)

		)
		*/

	print_r(link_header\parse('<http://example.org/>; rel="start http://example.net/relation/other"'));

		/*
		Array
		(
			[start] => Array
				(
					[uri] => http://example.org/
					[rel] => start http://example.net/relation/other
				)

			[http://example.net/relation/other] => Array
				(
					[uri] => http://example.org/
					[rel] => start http://example.net/relation/other
				)

		)
		*/


	// Header values can also be passed as an array. If there are repeated rels (like previous in the examples below) only the last one will be retained.
	print_r(link_header\parse(array(
		'<http://example.com/TheBook/chapter2>; rel="previous"; title="previous chapter"',
		'</>; rel="http://example.net/foo"',
		'</TheBook/chapter2>; rel="previous"; title*=UTF-8\'de\'letztes%20Kapitel, </TheBook/chapter4>; rel="next"; title*=UTF-8\'de\'n%c3%a4chstes%20Kapitel',
		'<http://example.org/>; rel="start http://example.net/relation/other"'
	)));

		/*
		Array
		(
			[previous] => Array
				(
					[uri] => /TheBook/chapter2
					[rel] => previous
					[title*] => TF-8'de'letztes%20Kapitel
				)

			[http://example.net/foo] => Array
				(
					[uri] => /
					[rel] => http://example.net/foo
				)

			[next] => Array
				(
					[uri] => /TheBook/chapter4
					[rel] => next
					[title*] => TF-8'de'n%c3%a4chstes%20Kapitel
				)

			[start] => Array
				(
					[uri] => http://example.org/
					[rel] => start http://example.net/relation/other
				)

			[http://example.net/relation/other] => Array
				(
					[uri] => http://example.org/
					[rel] => start http://example.net/relation/other
				)

		)
		*/


	// Examples that simple regex based parsers fail on:
	print_r(link_header\parse('<http://example.com/TheBook/chapter1>; rel="previous"; title="start, index"'));

		/*
		Array
		(
			[previous] => Array
				(
					[uri] => http://example.com/TheBook/chapter1
					[rel] => previous
					[title] => start, index
				)

		)
		*/

?>