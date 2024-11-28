<?php

namespace whitelabeled\TradeDoublerApi;

use DateTime;

class TradeDoublerClient
{
    /**
     * @var string Organization ID
     */
    private $organizationId;

    /**
     * @var string Token for reporting API
     */
    private $token;

    /**
     * @var string Currency ID
     */
    public $currency = 'EUR';

    /**
     * @var string API Endpoint
     */
    protected $endpoint = 'https://reports.tradedoubler.com/pan/';

    /**
     * @var string API method
     */
    protected $reportMethod = 'aReport3Key.action?format=XML&columns=pendingRule&columns=orderValue&columns=pendingReason&columns=orderNR&columns=leadNR&columns=link&columns=affiliateCommission&columns=device&columns=vendor&columns=browser&columns=os&columns=deviceType&columns=voucher_code&columns=open_product_feeds_name&columns=open_product_feeds_id&columns=productValue&columns=productNrOf&columns=productNumber&columns=productName&columns=graphicalElementId&columns=graphicalElementName&columns=siteId&columns=siteName&columns=pendingStatus&columns=eventId&columns=eventName&columns=epi2&columns=epi1&columns=lastModified&columns=timeInSession&columns=timeOfEvent&columns=timeOfVisit&columns=programId&columns=programName&reportTitleTextKey=REPORT3_SERVICE_REPORTS_AAFFILIATEEVENTBREAKDOWNREPORT_TITLE&reportName=aAffiliateEventBreakdownReport&includeMobile=1&breakdownOption=1&sortBy=lastModified&pending_status=1&setColumns=true';

    /**
     * TradeDoubler API client constructor.
     * @param $organizationId string Organization ID
     * @param $token          string Token
     */
    public function __construct($organizationId, $token)
    {
        $this->organizationId = $organizationId;
        $this->token = $token;
    }

    /**
     * Get all transactions from $startDate until $endDate.
     *
     * @param DateTime $startDate Start date
     * @param DateTime|null $endDate End date, optional (defaults to today)
     * @return array Transaction objects. Each part of a transaction is returned as a separate Transaction.
     */
    public function getTransactions(DateTime $startDate, DateTime $endDate = null)
    {
        if ($endDate == null) {
            $endDate = new DateTime();
        }

        $params = [
            'dateSelectionType' => 1,
            'startTimeHrs' => 0,
            'endTimeHrs' => 0,
            'filterOnTimeHrsInterval' => 'true',
            'event_id' => 0,
            'currencyId' => $this->currency,
            'latestDayToExecute' => 0,
            'startDate' => $startDate->format('d-m-Y'),
            'endDate' => $endDate->format('d-m-Y'),
            'organizationId' => $this->organizationId,
            'key' => $this->token,
        ];

        $query = '&' . http_build_query($params);
        $response = $this->makeRequest($this->reportMethod, $query);

        $transactions = [];

        // Decode XML:
        $xml = simplexml_load_string($response->getBody());

        if ($xml == null) {
            throw new \Exception('Failed to parse XML response');
        }

        $transactionsData = $xml->matrix->rows->row;

        if ($transactionsData != null) {
            foreach ($transactionsData as $transactionData) {
                $transaction = Transaction::createFromXml($transactionData);
                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }

    /**
     * @param $resource
     * @param $query
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest($resource, $query = "")
    {
        $uri = $this->endpoint . $resource . '?' . $query;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/xml',
            ],
        ]);

        // Check status code:
        if ($response->getStatusCode() != 200) {
            throw new \Exception('Request failed with status code ' . $response->getStatusCode());
        }

        return $response;
    }
}
