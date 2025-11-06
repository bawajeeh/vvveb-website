<?php

/**
 * Vvveb
 *
 * Copyright (C) 2022  Ziadin Givan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

namespace Vvveb\Controller\Tools;

use function Vvveb\__;
use Vvveb\Controller\Base;
use Vvveb\System\Images;
use function Vvveb\url;


class Search extends Base {
	function index() {
		//var_dump($this->view->menu);
		$text = $this->request->get['search'] ?? '';
		$type   = $this->request->get['type'] ?? '';

		$this->view->search = $text;
		$this->view->type   = $type;

		if (strlen($text) < 3) {
			$this->view->search = [];
			return;
		}

		$products   = new \Vvveb\Sql\ProductSQL();

		$options = [
			'limit' => 5,
			'like'  => $text,
		] + $this->global;

		unset($options['admin_id']);
		$results = $products->getAll($options);

		$search = [];

		if (isset($results['product'])) {
			$key = __('product');
			foreach ($results['product'] as $product) {
				$product['image'] = Images::image($product['image'], 'product', 'thumb');
				$url              = url(['module' => 'product/product', 'slug'=> $product['slug'], 'product_id' => $product['product_id'], 'type' => $product['type']]);

				$search[$key][]  = [
					'type' => 'cardimage',
					'src'  => $product['image'],
					'text' => $product['name'],
					'url'  => $url,
				];
			}
		}

		//if (count($search) < 5) {
		$posts   = new \Vvveb\Sql\PostSQL();
		$results = $posts->getAll($options);

		if (isset($results['post'])) {
			$key = __('post');
			foreach ($results['post'] as $post) {
				$post['image'] = Images::image($post['image'], 'post', 'thumb');
				$url           = url(['module' => 'content/post', 'slug'=> $post['slug'], 'post_id' => $post['post_id'], 'type' => $post['type']]);

				$search[$key][] = [
					'type' => 'cardimage',
					'src'  => $post['image'],
					'text' => $post['name'],
					'url'  => $url,
				];
			}
		}
		//}

		$users   = new \Vvveb\Sql\UserSQL();
		$results = $users->getAll($options + ['search' => $text]);

		if (isset($results['user'])) {
			$key = __('user');
			foreach ($results['user'] as $user) {
				$url           = url(['module' => 'user/user', 'user_id' => $user['user_id']]);
				if (isset($user['avatar'])) {
					$user['image']= Images::image($user['avatar'], 'user');
				}


				$search[$key][] = [
					'type' => 'cardimage',
					'src'  => $user['image'],
					'text' => $user['username'],
					'url'  => $url,
				];
			}
		}


		$results = [];
		foreach ($this->view->menu as  $key => $value) {
			if (isset($value['heading'])) {
				continue;
			}

			if (isset($value['name']) && (stripos($value['name'], $text) !== false)) {
				$results[$value['name']] = [
					'icon'  => $value['icon'] ?? '',
					'icon-img'  => $value['icon-img'] ?? '',
					'text' => $value['name'],
					'url' => $value['url'],
				];
			}

			if (isset($value['items']) && is_array($value['items'])) {
				foreach ($value['items'] as $submenu) {
					if (isset($submenu['heading'])) {
						continue;
					}

					if (isset($submenu['name']) && (stripos($submenu['name'], $text) !== false)) {
						$results[$submenu['name']] = [
							'icon'  => $submenu['icon'] ?? '',
							'icon-img'  => $submenu['icon-img'] ?? '',
							'text' => $value['name'] . ' > ' . $submenu['name'],
							'url' => $submenu['url'],
						];
					}

					if (isset($submenu['items']) && is_array($submenu['items'])) {
						foreach ($submenu['items'] as $subsubmenu) {
							if (isset($subsubmenu['heading'])) {
								continue;
							}

							if (isset($subsubmenu['name']) && (stripos($subsubmenu['name'], $text) !== false)) {
								$results[$subsubmenu['name']] = [
									'icon'  => $subsubmenu['icon'] ?? '',
									'icon-img'  => $subsubmenu['icon-img'] ?? '',
									'text' => $value['name'] . ' > ' . $submenu['name'] . ' > ' . $subsubmenu['name'],
									'url' => $subsubmenu['url'],
								];
							}
						}
					}
				}
			}
		}

		if ($results) {
			$search[__('Settings')] = $results;
		}


		$pages  = [
			'index/index'             => __('Home'),
			'product/index'           => __('Shop'),
			'content'                 => __('Blog'),
			'user/index'              => __('User'),
			'user/login/index'        => __('Login'),
			'user/signup/index'       => __('Signup'),
			'cart/cart/index'         => __('Cart'),
			'checkout/checkout/index' => __('Checkout'),
		];

		$key = __('pages');
		foreach ($pages as $route => $name) {
			if (stripos($name, $text) !== false) {
				$url          = url($route);
				$search[$key][$url] = [
					'icon'  => 'la la-external-link-alt',
					'text' => $name,
					'url' => $url,
				];

				break;
			}
		}

		$this->view->search = $search;
	}

	function autocomplete() {
	}
}
