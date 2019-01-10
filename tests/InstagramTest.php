<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InstagramTest extends PHPUnit_Framework_TestCase {

  private $http;

  public function setUp() {
    $this->client = new Parse();
    $this->client->http = new p3k\HTTP\Test(dirname(__FILE__).'/data/');
    $this->client->mc = null;
  }

  private function parse($params) {
    $request = new Request($params);
    $response = new Response();
    return $this->client->parse($request, $response);
  }

  public function testInstagramPhoto() {
    // Original URL: https://www.instagram.com/p/BO5rYVElvJq/
    $url = 'https://www.instagram.com/p/BO5rYVElvJq/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);
    $this->assertEquals('entry', $data['data']['type']);
    $this->assertEquals('photo', $data['data']['post-type']);
    $this->assertEquals('2017-01-05T23:31:32+00:00', $data['data']['published']);
    $this->assertContains('planning', $data['data']['category']);
    $this->assertContains('2017', $data['data']['category']);
    $this->assertEquals('Kind of crazy to see the whole year laid out like this. #planning #2017', $data['data']['content']['text']);
    $this->assertEquals(1, count($data['data']['photo']));
    $this->assertEquals(['https://instagram.fsjc1-3.fna.fbcdn.net/vp/af9471f885e6197478d71807a7cbf297/5CBA6E5F/t51.2885-15/e35/15803256_1832278043695907_4846092951052353536_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net'], $data['data']['photo']);
    $this->assertEquals('https://aaronparecki.com/', $data['data']['author']['url']);
    $this->assertEquals('Aaron Parecki', $data['data']['author']['name']);
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/45aee453740a714bf408f8947f89da8e/5CCB4B8E/t51.2885-19/s320x320/14240576_268350536897085_1129715662_a.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['author']['photo']);
  }

  public function testBGDpqNoiMJ0() {
    // https://www.instagram.com/p/BGDpqNoiMJ0/
    $url = 'http://www.instagram.com/BGDpqNoiMJ0';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertEquals('photo', $data['data']['post-type']);
    $this->assertSame([
      'type' => 'card',
      'name' => 'pk_spam',
      'url' => 'https://aaronparecki.com/',
      'photo' => 'https://scontent-frx5-1.cdninstagram.com/vp/74112f515c64726429c69fedcb927c2d/5CB64CF1/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-frx5-1.cdninstagram.com',
      'note' => 'My website is https://aaronparecki.com.dev/ and http://aaronpk.micro.blog/about/ and https://tiny.xyz.dev/'
    ], $data['data']['author']);

    $this->assertSame([
      'muffins',
      'https://indiewebcat.com/'
    ], $data['data']['category']);

    $this->assertEquals('Meow #muffins', $data['data']['content']['text']);
    $this->assertSame(['https://instagram.fsea1-1.fna.fbcdn.net/vp/9433ea494a8b055bebabf70fd81cfa32/5B51F092/t51.2885-15/e35/13266755_877794672348882_1908663476_n.jpg'], $data['data']['photo']);
    $this->assertEquals('2016-05-30T20:46:22-07:00', $data['data']['published']);

    $this->assertEquals('https://www.instagram.com/explore/locations/359000003/', $data['data']['location'][0]);

    $this->assertSame([
      'type' => 'card',
      'name' => 'Burnside 26',
      'url' => 'https://www.instagram.com/explore/locations/359000003/',
      'latitude' => 45.52322,
      'longitude' => -122.63885
    ], $data['data']['refs']['https://www.instagram.com/explore/locations/359000003/']);
  }

  public function testInstagramVideo() {
    // Original URL: https://www.instagram.com/p/BO_RN8AFZSx/
    $url = 'https://www.instagram.com/p/BO_RN8AFZSx/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertEquals('video', $data['data']['post-type']);
    $this->assertContains('100daysofmusic', $data['data']['category']);
    $this->assertEquals('Day 18. Maple and Spruce #100daysofmusic #100daysproject #the100dayproject https://aaronparecki.com/2017/01/07/14/day18', $data['data']['content']['text']);
    $this->assertEquals(1, count($data['data']['photo']));
    $this->assertEquals(['https://instagram.fsjc1-3.fna.fbcdn.net/vp/a77f8672f977413d2eb5239cd6d5c4cf/5C3A4ADF/t51.2885-15/e15/15624670_548881701986735_8264383763249627136_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net'], $data['data']['photo']);
    $this->assertEquals(1, count($data['data']['video']));
    $this->assertEquals(['https://instagram.fsjc1-3.fna.fbcdn.net/vp/90ed8fe576cba16e258c0f4cfc05299a/5C3A129E/t50.2886-16/15921147_1074837002642259_2269307616507199488_n.mp4?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net'], $data['data']['video']);
    $this->assertEquals('https://aaronparecki.com/', $data['data']['author']['url']);
    $this->assertEquals('Aaron Parecki', $data['data']['author']['name']);
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/45aee453740a714bf408f8947f89da8e/5CCB4B8E/t51.2885-19/s320x320/14240576_268350536897085_1129715662_a.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['author']['photo']);
  }

  public function testInstagramPhotoWithPersonTag() {
    // Original URL: https://www.instagram.com/p/BNfqVfVlmkj/
    $url = 'https://www.instagram.com/p/BNfqVfVlmkj/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals(2, count($data['data']['category']));
    $this->assertEquals(['type'=>'card','name'=>'KmikeyM™️','url'=>'https://kmikeym.com/','photo'=>'https://instagram.fsjc1-3.fna.fbcdn.net/vp/ea5b988b616dbcc778b3013bf2426d70/5CCAC7FC/t51.2885-19/s320x320/20634957_814691788710973_2275383796935163904_a.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net','note'=>"The world’s first publicly traded person.\n•\nAcct in collaboration with @norbertoinc\n•\nBecome a shareholder today!\n•"], $data['data']['refs']['https://kmikeym.com/']);
    $this->assertContains('https://kmikeym.com/', $data['data']['category']);
    $this->assertArrayHasKey('https://kmikeym.com/', $data['data']['refs']);
  }

  public function testInstagramPhotoWithVenue() {
    // Original URL: https://www.instagram.com/p/BN3Z5salSys/
    $url = 'https://www.instagram.com/p/BN3Z5salSys/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals(1, count($data['data']['location']));
    $this->assertContains('https://www.instagram.com/explore/locations/109284789535230/', $data['data']['location']);
    $this->assertArrayHasKey('https://www.instagram.com/explore/locations/109284789535230/', $data['data']['refs']);
    $venue = $data['data']['refs']['https://www.instagram.com/explore/locations/109284789535230/'];
    $this->assertEquals('XOXO Outpost', $venue['name']);
    $this->assertEquals('45.5261002', $venue['latitude']);
    $this->assertEquals('-122.6558081', $venue['longitude']);
    // Setting a venue should set the timezone
    $this->assertEquals('2016-12-10T21:48:56-08:00', $data['data']['published']);
  }

  public function testTwoPhotos() {
    // Original URL: https://www.instagram.com/p/BZWmUB_DVtp/
    $url = 'https://www.instagram.com/p/BZWmUB_DVtp/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals(2, count($data['data']['photo']));
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/6b09c3d5490ee3efb55849858a9ec014/5CBFBC38/t51.2885-15/e35/21827424_134752690591737_8093088291252862976_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['photo'][0]);
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/8b1b2e6efa86a4856ec37a60f0fa77f5/5CC2D34D/t51.2885-15/e35/21909774_347707439021016_5237540582556958720_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['photo'][1]);
    $this->assertArrayNotHasKey('video', $data['data']);
    $this->assertEquals(2, count($data['data']['category']));
  }

  public function testMixPhotosAndVideos() {
    // Original URL: https://www.instagram.com/p/BZWmpecjBwN/
    $url = 'https://www.instagram.com/p/BZWmpecjBwN/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('photo', $data['data']['post-type']); // we discard videos in this case right now
    $this->assertEquals(3, count($data['data']['photo']));
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/ee1a28763918069f3e54dad35be24ad8/5CCFBAB8/t51.2885-15/e35/21878922_686481254874005_8468823712617988096_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['photo'][0]);
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/ddc0ebe969bb1f9e6bf8adada0892c90/5C39EBC9/t51.2885-15/e15/21910026_1507234999368159_6974261907783942144_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['photo'][1]);
    $this->assertEquals('https://instagram.fsjc1-3.fna.fbcdn.net/vp/bfe032af795427443ea448840df1c3a4/5CCC8C88/t51.2885-15/e35/21878800_273567963151023_7672178549897297920_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net', $data['data']['photo'][2]);
    $this->assertArrayNotHasKey('video', $data['data']);
    $this->assertEquals(2, count($data['data']['category']));
  }

  public function testInstagramProfile() {
    $url = 'https://www.instagram.com/aaronpk/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertSame([
      'type' => 'card',
      'name' => 'Aaron Parecki',
      'url' => 'https://aaronparecki.com/',
      'photo' => 'https://instagram.fsjc1-3.fna.fbcdn.net/vp/45aee453740a714bf408f8947f89da8e/5CCB4B8E/t51.2885-19/s320x320/14240576_268350536897085_1129715662_a.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net',
      'note' => '🔒 oauth.net 🎥 backpedal.tv 🎙 streampdx.com 📡 w7apk.com'
    ], $data['data']);
  }

  public function testInstagramProfileWithBio() {
    $url = 'https://www.instagram.com/pk_spam/';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertSame([
      'type' => 'card',
      'name' => 'pk_spam',
      'url' => 'https://aaronparecki.com/',
      'photo' => 'https://scontent-frx5-1.cdninstagram.com/vp/74112f515c64726429c69fedcb927c2d/5CB64CF1/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-frx5-1.cdninstagram.com',
      'note' => 'My website is https://aaronparecki.com.dev/ and http://aaronpk.micro.blog/about/ and https://tiny.xyz.dev/'
    ], $data['data']);
  }

  public function testInstagramProfileFeed() {
    $url = 'https://www.instagram.com/pk_spam/';
    $response = $this->parse(['url' => $url, 'expect' => 'feed']);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('feed', $data['data']['type']);
    $this->assertEquals(12, count($data['data']['items']));
    $this->assertEquals('https://www.instagram.com/p/BsdlOmLh_IX/', $data['data']['items'][0]['url']);
    $this->assertEquals('https://www.instagram.com/p/BGFdtAViMJy/', $data['data']['items'][11]['url']);
  }

  public function testInstagramPhotoWithAltText() {
    $url = 'https://www.instagram.com/p/BsdjKytBZyx/';

    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('Pink text on a white background that says "Photo with alt text"', $data['data']['meta']['https://instagram.fsjc1-3.fna.fbcdn.net/vp/a7e61adf3d84f07863ffdb99f0fdcc86/5CD9B7F3/t51.2885-15/e35/47692478_2276538359047529_8318084305806697090_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net']['alt']);
  }

  public function testInstagramMultiPhotoWithAltText() {
    $url = 'https://www.instagram.com/p/BsdlOmLh_IX/';

    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals(200, $data['code']);
    $this->assertEquals('instagram', $data['source-format']);

    $this->assertEquals('A large pink "1" in a circle with a small green "2" behind it', $data['data']['meta']['https://instagram.fsjc1-3.fna.fbcdn.net/vp/90bf019b7396d7bc2b1ee02170902a2e/5CCC9B87/t51.2885-15/e35/47692921_321791688431421_3314633848293773579_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net']['alt']);
    $this->assertEquals('A large green "2" in a circle with a small pink "1" behind it', $data['data']['meta']['https://instagram.fsjc1-3.fna.fbcdn.net/vp/a6c93d8fcd5ad0e3b60f2ac0695eb34e/5CC3898E/t51.2885-15/e35/49663055_349750985612151_2949260446582336214_n.jpg?_nc_ht=instagram.fsjc1-3.fna.fbcdn.net']['alt']);
  }

}
