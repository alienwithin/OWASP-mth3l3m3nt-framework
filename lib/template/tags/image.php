<?php

namespace Template\Tags;

class Image extends \Template\TagHandler {

	/**
	 * build tag string
	 * @param $attr
	 * @param $content
	 * @return string
	 */
	function build($attr, $content) {

		if (isset($attr['src']) && (isset($attr['width'])||isset($attr['height']))) {
			$opt = array(
				'width'=>null,
				'height'=>null,
				'crop'=>false,
				'enlarge'=>false,
				'quality'=>75,
			);
			// merge into defaults
			$opt = array_intersect_key($attr + $opt, $opt);
			// get dynamic path
			$path = $this->template->token($attr['src']);
			// clean up attributes
			$attr=array_diff_key($attr,$opt);

			/** @var \Base $f3 */
			$f3 = \Base::instance();
			$opt = var_export($opt,true);

		$out='<?php $imgPath = \Template\Tags\Image::instance()->resize('.$path.','.$opt.'); ?>'
			.'<img src="<?php echo $imgPath;?>" '.$this->resolveParams($attr).' />';

		} else
			// just forward / bypass further processing
			$out = '<img'.$this->resolveParams($attr).' />';

		return $out;
	}

	function resize($path,$opt) {
		$f3 = \Base::instance();
		$hash = $f3->hash($path.$f3->serialize($opt));
		$new_file_name = $hash.'.jpg';
		$dst_path = $f3->get('TEMP').'img/';
		$path = explode('/', $path);
		$file = array_pop($path);
		if (!is_dir($dst_path))
			mkdir($dst_path,0775);
		if (!file_exists($dst_path.$new_file_name)) {
			$imgObj = new \Image($file, false, implode('/',$path).'/');
			$ow = $imgObj->width();
			$oh = $imgObj->height();
			if (!$opt['width'])
				$opt['width'] = round(($opt['height']/$oh)*$ow);
			if (!$opt['height'])
				$opt['height'] = round(($opt['width']/$ow)*$oh);
			$imgObj->resize((int)$opt['width'], (int)$opt['height'], $opt['crop'], $opt['enlarge']);
			$file_data = $imgObj->dump('jpeg', null, $opt['quality']);
			$f3->write($dst_path.$new_file_name, $file_data);
		}
		return $dst_path.$new_file_name;
	}
}