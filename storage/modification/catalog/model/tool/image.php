<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);
if (strtolower($extension) == 'svg') {
				$oct_webp_image = $octWebpIs = false;

				$image_new = $filename;
			} else {

		$image_old = $filename;
		$image_new = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) { 
				return DIR_IMAGE . $image_old;
			}
						
			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $image_old);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $image_new);
			} else {
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
			}
		}


			$oct_webp_image = $octWebpIs = false;

			$gd = gd_info();

			if (isset($gd['WebP Support']) && $gd['WebP Support'] && (isset($this->request->server['HTTP_ACCEPT']) && strpos($this->request->server['HTTP_ACCEPT'], 'webp')) && $this->config->get('theme_oct_showcase_webp')) {
				$octWebpIs = true;
			}

			if ($octWebpIs && $extension != 'gif') {
				$oct_webp_image = 'cache/webp/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.webp';

				if (!is_file(DIR_IMAGE . $oct_webp_image) || (filemtime(DIR_IMAGE . $image_new) > filemtime(DIR_IMAGE . $oct_webp_image))) {
					$path = '';

					$directories = explode('/', dirname($oct_webp_image));

					foreach ($directories as $directory) {
						$path = $path . '/' . $directory;

						if (!is_dir(DIR_IMAGE . $path)) {
							@mkdir(DIR_IMAGE . $path, 0777);
						}
					}

					if (strtolower($extension) == 'jpg' || strtolower($extension) == 'jpeg') {
						$image_original = imagecreatefromjpeg(DIR_IMAGE . $image_new);
					} elseif (strtolower($extension) == 'png') {
						$image_original = imagecreatefrompng(DIR_IMAGE . $image_new);
					}

					if (isset($image_original)) {
						imagewebp($image_original, DIR_IMAGE . $oct_webp_image, 85);
						imagedestroy($image_original);

						if (filesize(DIR_IMAGE . $oct_webp_image) % 2 == 1) {
							file_put_contents(DIR_IMAGE . $oct_webp_image, "\0", FILE_APPEND);
						}
					} else {
						$oct_webp_image = false;
					}
				}
			}
			
		$image_new = str_replace(' ', '%20', $image_new);  // fix bug when attach image on email (gmail.com). it is automatic changing space " " to +
		
}
		if ($this->request->server['HTTPS']) {
			return $this->config->get('config_ssl') . 'image/' . ((isset($oct_webp_image) && $oct_webp_image) ? $oct_webp_image : $image_new);
		} else {
			return $this->config->get('config_url') . 'image/' . ((isset($oct_webp_image) && $oct_webp_image) ? $oct_webp_image : $image_new);
		}
	}

    public function getAvif($imagePath, $use_extension_as_name = false)
    {

        // Якщо в урлі зустрічався +, то відбувалась заміна "+" => " "
        // Тимчасова заміна сивола +
        $from = '+';
        $to = 'ppplusppp';
        $imagePath = str_replace($from, $to, $imagePath);

        $imagePath = urldecode($imagePath);

        // повертаємо + в адерсу
        $imagePath = str_replace($to, $from, $imagePath);

        $fullImagePath = DIR_ROOT . 'image/' . $imagePath;

        // Отримуємо pathinfo
        $info = pathinfo($fullImagePath);
        $extension = strtolower($info['extension']);

        // Формуємо ім'я AVIF-файлу з урахуванням опції
        $filename = $info['filename'];
        if ($use_extension_as_name) {
            $filename .= '-' . $extension;
        }

        $outputPath = $info['dirname'] . '/' . $filename . '.avif';

        // Якщо AVIF вже існує і не пустий — повертаємо його URL
        if (file_exists($outputPath) && filesize($outputPath) > 0) {
            return str_replace(DIR_ROOT, HTTPS_SERVER, $outputPath);
        }

        // Якщо оригінального зображення не існує — нічого не робимо
        if (!file_exists($fullImagePath)) {
            return false;
        }

        // Отримуємо інформацію про зображення
        $imageInfo = getimagesize($fullImagePath);
        if (!$imageInfo) {
            return str_replace(DIR_ROOT, HTTPS_SERVER, $fullImagePath);
        }

        // Перевірка на максимальні розміри
        if ($imageInfo[0] > 3500 || $imageInfo[1] > 3500) {
            return str_replace(DIR_ROOT, HTTPS_SERVER, $fullImagePath);
        }

        // Спроба конвертації
        if (class_exists('Imagick')) {
            try {
                $imagick = new Imagick($fullImagePath);
                $imagick->setImageFormat('avif');
                $imagick->setImageDepth(8);
                $imagick->setCompressionQuality(85);

                $success = $imagick->writeImage($outputPath);
                $imagick->clear();
                $imagick->destroy();

                // Якщо не вдалось або вага 0 — повертаємо оригінал
                if (!$success || !file_exists($outputPath) || filesize($outputPath) === 0) {
                    @unlink($outputPath); // Очистити, якщо створено пустий
                    return str_replace(DIR_ROOT, HTTPS_SERVER, $fullImagePath);
                }

                return str_replace(DIR_ROOT, HTTPS_SERVER, $outputPath);
            } catch (Exception $e) {
                return str_replace(DIR_ROOT, HTTPS_SERVER, $fullImagePath);
            }
        }

        // Якщо Imagick недоступний — повертаємо оригінал
        return str_replace(DIR_ROOT, HTTPS_SERVER, $fullImagePath);
    }


    public function getAvifMass($imagePath)
    {
        $imagePath = urldecode($imagePath);
        $fullImagePath = DIR_ROOT . 'image/' . $imagePath;

        $info = pathinfo($fullImagePath);
        $outputPath = $info['dirname'] . '/' . $info['filename'] . '.avif';

        // Якщо AVIF вже існує і не пустий – нічого не робимо
        if (file_exists($outputPath) && filesize($outputPath) > 0) {
            return false;
        }

        // Якщо оригінального зображення не існує — нічого не робимо
        if (!file_exists($fullImagePath)) {
            return false;
        }

        $imageInfo = getimagesize($fullImagePath);
        if (!$imageInfo) {
            return false;
        }



        // Перевірка на розмір зображення
        if ($imageInfo[0] > 3000 || $imageInfo[1] > 3000) {
            return false;
        }

        if (class_exists('Imagick')) {
            try {
                $imagick = new Imagick($fullImagePath);
                $imagick->setImageFormat('avif');
                $imagick->setImageDepth(8);
                $imagick->setCompressionQuality(85);

                $success = $imagick->writeImage($outputPath);
                $imagick->clear();
                $imagick->destroy();

                if ($success && file_exists($outputPath) && filesize($outputPath) > 0) {
                    return true; // Згенеровано щойно
                }

                @unlink($outputPath); // Видаляємо пустий файл
                return false;
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }



}
