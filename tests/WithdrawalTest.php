<?php

namespace KuMex\SDK\Tests;

use KuMex\SDK\PrivateApi\Withdrawal;

class WithdrawalTest extends TestCase
{
    protected $apiClass    = Withdrawal::class;
    protected $apiWithAuth = true;

    /**
     * @dataProvider apiProvider
     * @param Withdrawal $api
     * @throws \KuMex\SDK\Exceptions\BusinessException
     * @throws \KuMex\SDK\Exceptions\HttpException
     * @throws \KuMex\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetQuotas(Withdrawal $api)
    {
        $data = $api->getQuotas('XBT');
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('limitAmount', $data);
        $this->assertArrayHasKey('withdrawMinFee', $data);
        $this->assertArrayHasKey('innerWithdrawMinFee', $data);
        $this->assertArrayHasKey('usedAmount', $data);
        $this->assertArrayHasKey('availableAmount', $data);
        $this->assertArrayHasKey('remainAmount', $data);
        $this->assertArrayHasKey('precision', $data);
        $this->assertArrayHasKey('currency', $data);
        $this->assertArrayHasKey('isWithdrawEnabled', $data);
        $this->assertArrayHasKey('withdrawMinSize', $data);
    }

    /**
     * @dataProvider apiProvider
     * @param Withdrawal $api
     * @throws \KuMex\SDK\Exceptions\BusinessException
     * @throws \KuMex\SDK\Exceptions\HttpException
     * @throws \KuMex\SDK\Exceptions\InvalidApiUriException
     */
    public function testApply(Withdrawal $api)
    {
        $params = [
            'currency' => 'XBT',
            'address'  => '1BcTdvq6Qdh7GnviHTYHq4tBvU32FfUbGz',
            'amount'   => 0.3,
            'remark'   => 'test apply withdrawal',
        ];
        $data = $api->apply($params);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('withdrawId', $data);
    }


    /**
     * @dataProvider apiProvider
     * @param Withdrawal $api
     * @return array
     * @throws \KuMex\SDK\Exceptions\BusinessException
     * @throws \KuMex\SDK\Exceptions\HttpException
     * @throws \KuMex\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetList(Withdrawal $api)
    {
        $params = [
            'currency' => 'BTC',
        ];
        $pagination = [
            'currentPage' => 1,
            'pageSize'    => 10,
        ];
        $data = $api->getList($params, $pagination);
        $this->assertPagination($data);
        foreach ($data['items'] as $item) {
            $this->assertInternalType('array', $item);
            $this->assertArrayHasKey('withdrawalId', $item);
            $this->assertArrayHasKey('walletTxId', $item);
            $this->assertArrayHasKey('address', $item);
            $this->assertArrayHasKey('memo', $item);
            $this->assertArrayHasKey('currency', $item);
            $this->assertArrayHasKey('amount', $item);
            $this->assertArrayHasKey('fee', $item);
            $this->assertArrayHasKey('isInner', $item);
            $this->assertArrayHasKey('status', $item);
            $this->assertArrayHasKey('createdAt', $item);
        }
    }

    /**
     * @dataProvider apiProvider
     * @param Withdrawal $api
     * @throws \KuMex\SDK\Exceptions\BusinessException
     * @throws \KuMex\SDK\Exceptions\HttpException
     * @throws \KuMex\SDK\Exceptions\InvalidApiUriException
     */
    public function testCancel(Withdrawal $api)
    {
        $data = $api->cancel('5c1cb7bb03aa6774239b772c');
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('cancelledWithdrawIds', $data);
    }
}