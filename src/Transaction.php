<?php

namespace whitelabeled\TradeDoublerApi;

use DateTime;

class Transaction {
    /**
     * @var string
     */
    public $generatedId;

    /**
     * @var DateTime
     */
    public $transactionDate;

    /**
     * @var DateTime
     */
    public $clickDate;

    /**
     * @var DateTime
     */
    public $lastModifiedDate;

    /**
     * @var string
     */
    public $program;

    /**
     * @var string
     */
    public $programId;

    /**
     * @var string
     */
    public $orderNr;

    /**
     * @var string
     */
    public $leadNr;

    /**
     * @var string
     */
    public $eventId;

    /**
     * @var string
     */
    public $eventName;

    /**
     * @var string
     */
    public $deviceType;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $statusReason;

    /**
     * @var string
     */
    public $epi1;

    /**
     * @var string
     */
    public $epi2;

    /**
     * @var double
     */
    public $commission;

    /**
     * @var double
     */
    public $orderValue;

    /**
     * @var int
     */
    public $mediaId;

    /**
     * @var string
     */
    public $mediaName;


    /**
     * Create a Transaction object from two JSON objects
     * @param $transData \stdClass Transaction data
     * @return Transaction
     */
    public static function createFromXml($transData) {
        $transaction = new Transaction();

        $transaction->program = (string)$transData->programName;
        $transaction->programId = (string)$transData->programId;

        $transaction->orderNr = (string)$transData->orderNR;
        $transaction->leadNr = (string)$transData->leadNR;
        $transaction->commission = (string)$transData->affiliateCommission;
        $transaction->orderValue = (string)$transData->orderValue;
        $transaction->epi1 = (string)$transData->epi1;
        $transaction->epi2 = (string)$transData->epi2;

        $transaction->eventId = (string)$transData->eventId;
        $transaction->eventName = (string)$transData->eventName;

        $transaction->mediaId = (string)$transData->siteId;
        $transaction->mediaName = (string)$transData->siteName;

        $transaction->clickDate = self::parseDate($transData->timeOfVisit);
        $transaction->transactionDate = self::parseDate($transData->timeOfEvent);
        $transaction->lastModifiedDate = self::parseDate($transData->lastModified);

        $transaction->deviceType = (string)$transData->deviceType;
        $transaction->status = (string)$transData->pendingStatus;
        $transaction->statusReason = (string)$transData->pendingReason;

        $transaction->generateId();

        return $transaction;
    }

    /**
     * Parse a date
     * @param $date string Date/time string
     * @return DateTime|null
     */
    private static function parseDate($date) {
        if ($date == null) {
            return null;
        } else {
            return new \DateTime($date);
        }
    }

    /**
     * Generate an ID based on event time, program ID and order NR.
     */
    private function generateId() {
        $this->generatedId = 'gen-' . $this->programId . '-' . sha1($this->orderNr . $this->transactionDate->format(DATE_ISO8601));
    }
}
