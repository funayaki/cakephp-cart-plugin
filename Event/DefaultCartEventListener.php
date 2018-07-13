<?php

class DefaultCartEventListener implements EventListener {

	public function implementedEvents() {
		return array(
			'Cart.calculateTotals' => 'calculateTotals'
		);
	}

	public function calculateTotals(Event $Event) {
		$Model = $Event->subject();
		$cartData = $Event->data['cartData'];

		$cartData[$Model->alias]['total'] = 0.00;

		if (!empty($cartData['CartsItem'])) {
			foreach ($cartData['CartsItem'] as $key => $item) {
				$cartData['CartsItem'][$key]['total'] = (float)$item['quantity'] * (float)$item['price'];
				$cartData[$Model->alias]['total'] += (float)$cartData['CartsItem'][$key]['total'];
			}
		}

		return $cartData;
	}

}