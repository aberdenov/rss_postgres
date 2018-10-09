<?php
	class Feed {
		public $feed_url = 'http://www.spbren.ru/upload/yandexFeedKurort.xml';

		public function getData() {
			$sql = "TRUNCATE main";
			db_query($sql);

			$rss = simplexml_load_file($this->feed_url);

			foreach ($rss->offer as $item) {
				$price 		= '';
				$image 		= '';
				$date 		= '';

				if (!empty($item->price->{'value'})) 		$price = $item->price->{'value'};
				if (!empty($item->{'image'})) 				$image = $item->{'image'};
				if (!empty($item->{'last-update-date'})) 	$date  = $item->{'last-update-date'};
				
				$result = $this->insertDb($price, $image, $date);
			}
		}

		public function insertDb($field1, $field2, $field3) {
			$field1 = pg_escape_string($field1);
			$field2 = pg_escape_string($field2);
			$field3 = date("Y-m-d H:m:s", strtotime($field3));

			$sql = "INSERT INTO main (price, image, date) VALUES ('".$field1."', '".$field2."', '".$field3."')";
			db_query($sql);
		}

		public function showResult() {
			$min_price 		= db_get_data("SELECT MIN(price) AS min_price FROM main", "min_price");
			$max_price 		= db_get_data("SELECT MAX(price) AS max_price FROM main", "max_price");
			$last_update 	= db_get_data("SELECT date FROM main ORDER BY date DESC LIMIT 1", "date");
			$image 			= db_get_data("SELECT image FROM main ORDER BY random() LIMIT 1", "image");
			$count 			= db_table_count("main", "");

			$out = '<table border="1">
					<tr>
						<td>Минимальная для каждого жилого комплекса</td>
						<td>Максимальная для каждого жилого комплекса</td>
						<td>Изображение планировки любой квартиры в жилом комплексе</td>
						<td>Количество квартир в ЖК</td>
						<td>Дату последнего обновления информации о ЖК</td>
					</tr>
					<tr>
						<td>'.$min_price.'</td>
						<td>'.$max_price.'</td>
						<td><img src="'.$image.'" width="300"></td>
						<td>'.$count.'</td>
						<td>'.$last_update.'</td>
					</tr>
					</table>';

			return $out;
		}
	}
?>