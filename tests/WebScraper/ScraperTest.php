<?php
namespace App\Tests\WebScraper;

use App\WebScraper\Scraper;
use PHPUnit\Framework\TestCase;

class ScraperTest extends TestCase
{
    const JSON_TEST = '{"results":{"title":"House Prices in EC2","metaTagDescription":"The average price for a property in EC2 is &pound;1,283,054 over the last year. Use Rightmove online house price checker tool to find out exactly how much properties sold for in EC2 since 1995 (based on official Land Registry data).","containsScotland":false,"resultCount":"2,905","properties":[{"address":"Flat 141, Shakespeare Tower, Barbican, London, Greater London EC2Y 8DR","propertyType":"Flat","bedrooms":3,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/81676210\/71134_BAR190173_IMG_17_0000_max_135x100.jpg","count":16},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;1,600,000","dateSold":"26 Nov 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;640,000","dateSold":"31 Mar 2006","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;555,000","dateSold":"19 Dec 2002","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;340,000","dateSold":"11 Aug 1999","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52018,"lng":-0.09497},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=81676210&sale=91797255&country=england"},{"address":"Flat 157, Thomas More House, Barbican, London, Greater London EC2Y 8BU","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/81965218\/71134_BAR110259_IMG_17_0000_max_135x100.jpg","count":16},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;640,000","dateSold":"13 Nov 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51903,"lng":-0.09603},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=81965218&sale=91797252&country=england"},{"address":"824, Frobisher Crescent, London, Greater London EC2Y 8HD","propertyType":"Flat","bedrooms":3,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/77k\/76792\/55108257\/76792_HAM555-t-3782_IMG_13_0000_max_135x100.jpg","count":12},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;1,625,000","dateSold":"10 Nov 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52043,"lng":-0.09381},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=55108257&sale=91797261&country=england"},{"address":"Flat 119, Thomas More House, Barbican, London, Greater London EC2Y 8BU","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/220k\/219962\/80176324\/219962_DWR00040E_IMG_01_0000_max_135x100.jpg","count":14},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;665,000","dateSold":"6 Nov 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;195,000","dateSold":"11 Dec 2000","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;86,000","dateSold":"3 Mar 1995","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51903,"lng":-0.09603},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=80176324&sale=91797249&country=england"},{"address":"Flat 2204, 2, Principal Place, London, Greater London EC2A 2FE","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,388,160","dateSold":"6 Nov 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""},{"address":"Flat 312, Willoughby House, Barbican, London, Greater London EC2Y 8BL","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/7k\/6242\/76157014\/6242_29333638_IMG_12_0000_max_135x100.jpg","count":12},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;700,000","dateSold":"26 Oct 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51877,"lng":-0.09114},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=76157014&sale=91797246&country=england"},{"address":"Flat 107, Breton House, Barbican, London, Greater London EC2Y 8PQ","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/81364708\/71134_BAR130277_IMG_08_0000_max_135x100.jpg","count":12},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;870,000","dateSold":"19 Oct 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;809,995","dateSold":"30 Jul 2013","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;265,000","dateSold":"13 Dec 2001","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;90,550","dateSold":"23 Jan 1995","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52133,"lng":-0.09377},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=81364708&sale=91797264&country=england"},{"address":"Flat 1, 133, Curtain Road, London, Greater London EC2A 3BX","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;490,000","dateSold":"9 Oct 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;499,950","dateSold":"6 Nov 2014","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52615,"lng":-0.08074},"detailUrl":""},{"address":"Flat 2507, 2, Principal Place, London, Greater London EC2A 2FE","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,200,000","dateSold":"9 Oct 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""},{"address":"15, French Place, London, Greater London E1 6JB","propertyType":"Flat","bedrooms":0,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/34k\/33548\/76792294\/33548_SHO200006_IMG_01_0000_max_135x100.jpg","count":9},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;270,000","dateSold":"30 Sep 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;220,000","dateSold":"24 Jan 2013","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52576,"lng":-0.07845},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=76792294&sale=11594155&country=england"},{"address":"Flat 119, Willoughby House, Barbican, London, Greater London EC2Y 8BL","propertyType":"Flat","bedrooms":2,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/73680199\/71134_BAR160102_IMG_02_0000_max_135x100.jpg","count":16},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;867,500","dateSold":"18 Sep 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51877,"lng":-0.09114},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=73680199&sale=91578375&country=england"},{"address":"Flat 2901, 2, Principal Place, London, Greater London EC2A 2FE","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,901,000","dateSold":"11 Sep 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""},{"address":"Flat 4204, 2, Principal Place, London, Greater London EC2A 2FG","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;2,398,470","dateSold":"8 Sep 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""},{"address":"Flat 401, Gilbert House, Barbican, London, Greater London EC2Y 8BD","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/77k\/76792\/71112537\/76792_103352001036_IMG_01_0000_max_135x100.jpg","count":15},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;635,000","dateSold":"3 Sep 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51916,"lng":-0.09314},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=71112537&sale=91578372&country=england"},{"address":"Flat 5, City Lofts 112-116, Tabernacle Street, London, Greater London EC2A 4LE","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,540,000","dateSold":"26 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;460,000","dateSold":"30 Jan 2004","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;518,875","dateSold":"28 Apr 2000","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52532,"lng":-0.08452},"detailUrl":""},{"address":"Flat 608, Mountjoy House, Barbican, London, Greater London EC2Y 8BP","propertyType":"Flat","bedrooms":3,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/76063075\/71134_BAR190219_IMG_03_0000_max_135x100.jpg","count":9},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;1,680,000","dateSold":"24 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;215,000","dateSold":"16 Apr 1996","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51857,"lng":-0.09547},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=76063075&sale=91578378&country=england"},{"address":"Flat 72, Andrewes House, Barbican, London, Greater London EC2Y 8AY","propertyType":"Flat","bedrooms":2,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/85k\/84061\/97773737\/84061_TML389_IMG_00_0000_max_135x100.jpg","count":26},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;817,000","dateSold":"11 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;107,500","dateSold":"13 Nov 1996","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.5186,"lng":-0.09201},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=97773737&sale=91578369&country=england"},{"address":"Flat 372, Shakespeare Tower, Barbican, London, Greater London EC2Y 8NJ","propertyType":"Flat","bedrooms":3,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/73445653\/71134_BAR130006_IMG_03_0000_max_135x100.jpg","count":21},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;1,740,000","dateSold":"10 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;375,000","dateSold":"3 Nov 1999","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52018,"lng":-0.09497},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=73445653&sale=91191213&country=england"},{"address":"516, Bunyan Court, Barbican, London, Greater London EC2Y 8DH","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,210,000","dateSold":"10 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;1,100,000","dateSold":"7 Apr 2016","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52093,"lng":-0.09667},"detailUrl":""},{"address":"Flat 347, Ben Jonson House, Barbican, London, Greater London EC2Y 8NQ","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/7k\/6242\/72911266\/6242_28937761_IMG_01_0000_max_135x100.jpg","count":12},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;530,000","dateSold":"4 Aug 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;70,000","dateSold":"10 Oct 1996","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52088,"lng":-0.09408},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=72911266&sale=91191216&country=england"},{"address":"Flat 2804, 2, Principal Place, London, Greater London EC2A 2FE","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;1,432,320","dateSold":"31 Jul 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""},{"address":"Flat 30, Defoe House, Barbican, London, Greater London EC2Y 8DN","propertyType":"Flat","bedrooms":1,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/116k\/115204\/45188722\/115204_30DefoeHouse_IMG_03_0001_max_135x100.jpg","count":8},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;800,000","dateSold":"28 Jul 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;779,995","dateSold":"17 Apr 2015","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;544,000","dateSold":"26 Oct 2007","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;442,021","dateSold":"1 Mar 2007","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;250,000","dateSold":"21 Nov 2001","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;137,000","dateSold":"29 Jan 1998","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51992,"lng":-0.09541},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=45188722&sale=91191210&country=england"},{"address":"Flat 304, Bryer Court, Barbican, London, Greater London EC2Y 8DE","propertyType":"Flat","bedrooms":0,"images":{"imageUrl":"https:\/\/media.rightmove.co.uk\/dir\/72k\/71134\/85102336\/71134_BAR200079_L_IMG_01_0000_max_135x100.jpg","count":9},"hasFloorPlan":true,"transactions":[{"displayPrice":"&pound;505,000","dateSold":"24 Jul 2020","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;183,000","dateSold":"7 Nov 2003","tenure":"Leasehold","newBuild":false},{"displayPrice":"&pound;89,500","dateSold":"23 Jan 1998","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.52065,"lng":-0.0961},"detailUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/detailMatching.html?prop=85102336&sale=91191207&country=england"},{"address":"Flat 1912, 5, Moor Lane, London, Greater London EC2Y 9AZ","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;555,000","dateSold":"22 Jul 2020","tenure":"Leasehold","newBuild":false}],"location":{"lat":51.51983,"lng":-0.09023},"detailUrl":""},{"address":"Flat 1502, 2, Principal Place, London, Greater London EC2A 2FD","propertyType":"Flat","bedrooms":null,"images":{"imageUrl":"\/spw\/images\/placeholder\/no-image.svg","count":0},"hasFloorPlan":false,"transactions":[{"displayPrice":"&pound;798,700","dateSold":"10 Jul 2020","tenure":"Leasehold","newBuild":true}],"location":{"lat":51.52305,"lng":-0.08332},"detailUrl":""}]},"sidebar":{"blurb":["Properties in EC2 had an overall average price of &pound;1,283,054 over the last year.","The majority of sales in EC2 during the last year were flats, selling for an average price of &pound;1,287,067. Terraced properties sold for an average of &pound;937,960.","Overall, sold prices in EC2 over the last year were 15% up on the previous year and 30% up on the 2017 peak of &pound;988,941."],"nearbyLocations":{"title":"House prices near EC2","links":[{"text":"House prices in Shoreditch","url":"\/house-prices\/shoreditch.html"},{"text":"House prices in Hackney","url":"\/house-prices\/hackney.html"},{"text":"House prices in Islington","url":"\/house-prices\/islington.html"},{"text":"House prices in Bermondsey","url":"\/house-prices\/bermondsey.html"},{"text":"House prices in Bethnal Green","url":"\/house-prices\/bethnal-green.html"},{"text":"House prices in Whitechapel","url":"\/house-prices\/whitechapel.html"},{"text":"House prices in Clerkenwell","url":"\/house-prices\/clerkenwell.html"},{"text":"House prices in Camden","url":"\/house-prices\/camden.html"},{"text":"House prices in Pimlico","url":"\/house-prices\/pimlico.html"},{"text":"House prices in Canary Wharf","url":"\/house-prices\/canary-wharf.html"}]},"propertyValueLinks":{"title":"What is your property worth?","links":[{"text":"Agent Property Valuation","url":"\/property-valuation.html"},{"text":"Market Trends","url":"\/house-prices-in-my-area.html"},{"text":"Price Comparison Report","url":"\/house-value.html"},{"text":"Estate agents in EC2","url":"\/estate-agents\/find.html?locationIdentifier=REGION^91984"},{"text":"Properties for sale in EC2","url":"\/property-for-sale\/find.html?locationIdentifier=REGION^91984"},{"text":"Properties to let in EC2","url":"\/property-to-rent\/find.html?locationIdentifier=REGION^91984"},{"text":"Selling guide","url":"\/resources\/property-guides\/selling-guide.html"},{"text":"Buying guide","url":"\/resources\/property-guides\/buying-guide.html"},{"text":"House Price Index","url":"\/news\/house-price-index"}]},"staticMapUrl":"https:\/\/media.rightmove.co.uk\/map\/_generate?polygonLineColor=%232E8E89FF&polygonFillColor=%232E8E8914&width=278&height=246&longitude=-0.08661818520100442&latitude=51.51933531083577&mapPolygon=umlyHn%60RjBuI%7EDoj%40e%40o%5DkOkNc%40_GnBoFkHwIuFpKsOwCaJgEuI%7BAyOtEb%40hK%60CbWfDtSnFp%40zMaAvE%60BsBp_%40I%60GhCtSzQwAfRtA&signature=L72msGY_SCwPnkwoQJmNBg6zecw=","mapViewUrl":"https:\/\/www.rightmove.co.uk\/house-prices\/search.html?showMapView=showMapView&housePricesMap=Map+View&locationIdentifier=REGION%5E91984&propertyType=0"},"searchLocation":{"displayName":"EC2","searchName":"ec2","locationType":"REGION","locationId":"91984"},"searchParameters":{},"searchParameterDefaults":{"radius":"0.0","soldIn":"30","propertyType":"ANY","propertyCategory":"ANY","tenure":"ANY","sortBy":"DATE_SOLD"},"pagination":{"current":1,"first":1,"last":40,"total":2905},"leadValuationModel":null,"disclaimer":{"showLandReg":true,"showRos":false,"loadDates":{"landReg":{"earliestTransaction":"1 January 1995","mostRecentTransaction":"21 December 2020","lastLoadDate":"10 February 2021"},"ros":{"earliestTransaction":"18 October 1996","mostRecentTransaction":"31 December 2020","lastLoadDate":"10 February 2021"}}},"mortgageWidgetModel":{"currentAverage":"&pound;1,283,054","percentageChange":"15%","isIncrease":true}}';

    /**
     *
     */
    public function testGetNextPageUrl()
    {
        $scraper = new Scraper();
        $url = 'https://www.rightmove.co.uk/house-prices/ec2.html?page=39';
        $result = $scraper->getNextPageUrl($url, 40, 'page');

        // assert that your calculator added the numbers correctly!
        $equals = 'https://www.rightmove.co.uk/house-prices/ec2.html?page=40';
        $this->assertEquals($equals, $result);
    }

    /**
     *
     */
    public function testSubmitSearch()
    {
        $scraper = new Scraper();
        $url = 'https://www.rightmove.co.uk/house-prices.html';
        $searches = [
            'EC2' => 'https://www.rightmove.co.uk/house-prices/ec2.html?country=england&referrer=landingPage&searchLocation=EC2',
            'WC2' => 'https://www.rightmove.co.uk/house-prices/wc2.html?country=england&referrer=landingPage&searchLocation=WC2',
        ];
        
        foreach ($searches as $key => $value) {
            $forms = [];
            $form = new \stdClass();
            $form->selectButton = 'housePrices';
            $form->form = [
                'searchLocation' => $key
            ];
            $forms[] = $form;

            $result = $scraper->submitSearch($url, $forms);
            $this->assertEquals($value, $result);
        }
    }

    /**
     *
     */
    public function testGetSearchPageJsonData()
    {
        $scraper = new Scraper();

        $searches = [];
        $search = new \stdClass();
        $search->url = 'https://www.rightmove.co.uk/house-prices/ec2.html?country=england&referrer=landingPage&searchLocation=EC2';
        $search->start = "{\"results";
        $search->end = "window.__APP_CONFIG__";

        $searches[] = $search;

        foreach ($searches as $key => $value) {
            $current = $searches[$key];
            $result = $scraper->getSearchPageJsonData($current->url, $current->start, $current->end);

            $this->assertEquals(self::JSON_TEST, json_encode($result));
        }
    }
}