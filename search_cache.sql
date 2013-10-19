CREATE TABLE IF NOT EXISTS `search_cache` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `query_text` varchar(30) NOT NULL,
  `num_results` int(10) NOT NULL,
  `cache_result_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;