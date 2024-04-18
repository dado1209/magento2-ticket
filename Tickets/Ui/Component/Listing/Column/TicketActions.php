<?php

namespace Favicode\Tickets\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class EditActions
 */
class TicketActions extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['ticket_id']) && isset($item['website_id'])) {
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => $this->context->getUrl(
                            'tickets/view/index',
                            ['ticket_id' => $item['ticket_id'], 'website_id' => $item['website_id']]
                        ),
                        'label' => __('View')
                    ],
                    'close' => [
                        'href' => $this->context->getUrl(
                            'tickets/close/index',
                            ['ticket_id' => $item['ticket_id'], 'website_id' => $item['website_id']]
                        ),
                        'label' => __('Close')
                    ],
                    'reply' => [
                        'href' => $this->context->getUrl(
                            'tickets/view/reply',
                            ['ticket_id' => $item['ticket_id'], 'website_id' => $item['website_id']]
                        ),
                        'label' => __('Reply')
                    ],
                ];
            }
        }

        return $dataSource;
    }

}
