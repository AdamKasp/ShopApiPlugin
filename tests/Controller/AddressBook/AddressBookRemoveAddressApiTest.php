<?php

declare(strict_types=1);

namespace Tests\Sylius\ShopApiPlugin\Controller\AddressBook;

use PHPUnit\Framework\Assert;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Sylius\ShopApiPlugin\Controller\JsonApiTestCase;
use Tests\Sylius\ShopApiPlugin\Controller\Utils\ShopUserLoginTrait;

final class AddressBookRemoveAddressApiTest extends JsonApiTestCase
{
    use ShopUserLoginTrait;

    /**
     * @test
     */
    public function it_deletes_address_from_address_book(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'country.yml', 'address.yml']);
        $this->logInUser('oliver@queen.com', '123password');

        /** @var AddressRepositoryInterface $addressRepository */
        $addressRepository = $this->get('sylius.repository.address');
        /** @var AddressInterface $address */
        $address = $addressRepository->findOneBy(['street' => 'Kupreska']);

        $response = $this->removeAddress((string) $address->getId());

        $address = $addressRepository->findOneBy(['street' => 'Kupreska']);
        Assert::assertNull($address);

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function it_returns_bad_request_exception_if_address_has_not_been_found(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'country.yml', 'address.yml']);
        $this->logInUser('oliver@queen.com', '123password');

        $response = $this->removeAddress('-1');
        $this->assertResponseCode($response, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_validates_if_current_user_is_owner_of_address(): void
    {
        $this->loadFixturesFromFiles(['channel.yml', 'customer.yml', 'country.yml', 'address.yml']);
        $this->logInUser('oliver@queen.com', '123password');

        /** @var AddressRepositoryInterface $addressRepository */
        $addressRepository = $this->get('sylius.repository.address');
        /** @var AddressInterface $address */
        $address = $addressRepository->findOneBy(['street' => 'Vukovarska']);

        $response = $this->removeAddress((string) $address->getId());
        $this->assertResponseCode($response, Response::HTTP_BAD_REQUEST);
    }

    private function removeAddress(string $id): Response
    {
        $this->client->request(
            'DELETE',
            sprintf('/shop-api/address-book/%s', $id),
            [],
            [],
            self::CONTENT_TYPE_HEADER
        );

        return $this->client->getResponse();
    }
}
