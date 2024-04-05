<?php
$settings = array(
    0 =>
        array(
            'id'          => 1,
            'key'         => 'contact_info',
            'name'        => 'Contact Info',
            'description' => 'Contact Information of Smart Fish BD',
            'value'       => '[{"title":"Smart Fish - Manage and Monitor Your Aquarium with Smart Fish","favicon":"uploads\/favicon.png","address":"Calash, Dhanbari, Tangail, 1997 Bangladesh\r\nMohammadpur, Dhaka","phone":"+880 1710-011072","email":"smartfishbd2024@gmail.com","description":null}]',
            'field'       => json_encode([
                "name"      => "value",
                "label"     => "Setting",
                "type"      => "repeatable",
                "subfields" => [
                    [
                        "name" => "title",
                        "type" => "text",
                        "tab"  => "basic"
                    ],
                    [
                        "name" => "favicon",
                        "type" => "browse",
                        "tab"  => "media"
                    ],
                    [
                        "name" => "address",
                        "type" => "textarea",
                        "tab"  => "basic"
                    ],
                    [
                        "name" => "phone",
                        "type" => "text",
                        "tab"  => "basic"
                    ],
                    [
                        "name" => "email",
                        "type" => "email",
                        "tab"  => "basic"
                    ],
                    [
                        "name" => "description",
                        "type" => "ckeditor",
                        "tab"  => "basic"
                    ],
                ],
                'init_rows' => 1, // number of empty rows to be initialized, by default 1
                'min_rows'  => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows'  => 1, // maximum rows allowed, when reached the "new item" button will be hidden

            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    1 =>
        array(
            'id'          => 2,
            'key'         => 'about',
            'name'        => 'About',
            'description' => 'Website About Information',
            'value'       => '[{"image":"uploads\/abouts\/about.jpg","description":"<p>Welcome to Smart Fish BD, a pioneering initiative established in 2024 by a team of exceptional individuals comprising scientists, engineers, software developers, and mobile app developers. Our mission is clear: to spearhead the development of a smart fishery system that spans across our entire nation.<\/p>\r\n\r\n<p>At Smart Fish BD, we recognize the critical importance of sustainable fisheries management for the well-being of our ecosystems, communities, and future generations. Through the integration of cutting-edge technology and interdisciplinary expertise, we aim to revolutionize the way fisheries are managed, monitored, and sustained.<\/p>\r\n\r\n<p>With a focus on innovation, efficiency, and environmental stewardship, our platform endeavors to empower fishermen, policymakers, and stakeholders with intelligent tools and insights. By harnessing the power of data analytics, IoT devices, and mobile applications, we strive to optimize fishing practices, mitigate risks, and promote responsible resource utilization.<\/p>\r\n\r\n<p>Join us on this transformative journey as we work tirelessly to build a smarter, more resilient fishery network that ensures the long-term viability of our aquatic ecosystems while supporting the livelihoods of fishing communities nationwide. Together, let&#39;s shape a future where technology and sustainability converge to foster thriving marine environments and prosperous societies.<\/p>"}]',
            'field'       => json_encode([
                "name"      => "value",
                "label"     => "About",
                "type"      => "repeatable",
                "subfields" => [
                    [
                        "name" => "image",
                        "type" => "browse",
                    ],
                    [
                        "name" => "description",
                        "type" => "ckeditor",
                    ],
                ],
                'init_rows' => 1, // number of empty rows to be initialized, by default 1
                'min_rows'  => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows'  => 1, // maximum rows allowed, when reached the "new item" button will be hidden

            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    2 =>
        array(
            'id'          => 3,
            'key'         => 'privacy_policy',
            'name'        => 'Privacy Policy',
            'description' => 'Privacy Policy',
            'value'       => '[{"title":"Privacy Policy for smart-fish-bd","description":"<div class=\"translations-content-container\">\r\n<div class=\"container\">\r\n<div class=\"tab-content translations-content-item en visible\" id=\"en\">\r\n<h1>Privacy Policy<\/h1>\r\n<p>Last updated: January 01, 2023<\/p>\r\n<p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.<\/p>\r\n<p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.<\/p>\r\n<h1>Interpretation and Definitions<\/h1>\r\n<h2>Interpretation<\/h2>\r\n<p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.<\/p>\r\n<h2>Definitions<\/h2>\r\n<p>For the purposes of this Privacy Policy:<\/p>\r\n<ul>\r\n<li>\r\n<p><strong>Account<\/strong> means a unique account created for You to access our Service or parts of our Service.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Company<\/strong> (referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to smart-fish-bd.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Cookies<\/strong> are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Country<\/strong> refers to: Bangladesh<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Device<\/strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Personal Data<\/strong> is any information that relates to an identified or identifiable individual.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Service<\/strong> refers to the Website.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Service Provider<\/strong> means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Third-party Social Media Service<\/strong> refers to any website or any social network website through which a User can log in or create an account to use the Service.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Usage Data<\/strong> refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Website<\/strong> refers to smart-fish-bd, accessible from <a href=\"https:\/\/www.smart-fish-bd.com\" rel=\"external nofollow noopener\" target=\"_blank\">https:\/\/www.smart-fish-bd.com<\/a><\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>You<\/strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.<\/p>\r\n<\/li>\r\n<\/ul>\r\n<h1>Collecting and Using Your Personal Data<\/h1>\r\n<h2>Types of Data Collected<\/h2>\r\n<h3>Personal Data<\/h3>\r\n<p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:<\/p>\r\n<ul>\r\n<li>\r\n<p>Email address<\/p>\r\n<\/li>\r\n<li>\r\n<p>First name and last name<\/p>\r\n<\/li>\r\n<li>\r\n<p>Phone number<\/p>\r\n<\/li>\r\n<li>\r\n<p>Address, State, Province, ZIP\/Postal code, City<\/p>\r\n<\/li>\r\n<li>\r\n<p>Usage Data<\/p>\r\n<\/li>\r\n<\/ul>\r\n<h3>Usage Data<\/h3>\r\n<p>Usage Data is collected automatically when using the Service.<\/p>\r\n<p>Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.<\/p>\r\n<p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.<\/p>\r\n<p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.<\/p>\r\n<h3>Information from Third-Party Social Media Services<\/h3>\r\n<p>The Company allows You to create an account and log in to use the Service through the following Third-party Social Media Services:<\/p>\r\n<ul>\r\n<li>Google<\/li>\r\n<li>Facebook<\/li>\r\n<li>Twitter<\/li>\r\n<li>LinkedIn<\/li>\r\n<\/ul>\r\n<p>If You decide to register through or otherwise grant us access to a Third-Party Social Media Service, We may collect Personal data that is already associated with Your Third-Party Social Media Service\'s account, such as Your name, Your email address, Your activities or Your contact list associated with that account.<\/p>\r\n<p>You may also have the option of sharing additional information with the Company through Your Third-Party Social Media Service\'s account. If You choose to provide such information and Personal Data, during registration or otherwise, You are giving the Company permission to use, share, and store it in a manner consistent with this Privacy Policy.<\/p>\r\n<h3>Tracking Technologies and Cookies<\/h3>\r\n<p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:<\/p>\r\n<ul>\r\n<li><strong>Cookies or Browser Cookies.<\/strong> A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so that it will refuse Cookies, our Service may use Cookies.<\/li>\r\n<li><strong>Web Beacons.<\/strong> Certain sections of our Service and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those pages or opened an email and for other related website statistics (for example, recording the popularity of a certain section and verifying system and server integrity).<\/li>\r\n<\/ul>\r\n<p>Cookies can be \"Persistent\" or \"Session\" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser. Learn more about cookies on the <a href=\"https:\/\/www.freeprivacypolicy.com\/blog\/sample-privacy-policy-template\/#Use_Of_Cookies_And_Tracking\" target=\"_blank\">Free Privacy Policy website<\/a> article.<\/p>\r\n<p>We use both Session and Persistent Cookies for the purposes set out below:<\/p>\r\n<ul>\r\n<li>\r\n<p><strong>Necessary \/ Essential Cookies<\/strong><\/p>\r\n<p>Type: Session Cookies<\/p>\r\n<p>Administered by: Us<\/p>\r\n<p>Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Cookies Policy \/ Notice Acceptance Cookies<\/strong><\/p>\r\n<p>Type: Persistent Cookies<\/p>\r\n<p>Administered by: Us<\/p>\r\n<p>Purpose: These Cookies identify if users have accepted the use of cookies on the Website.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>Functionality Cookies<\/strong><\/p>\r\n<p>Type: Persistent Cookies<\/p>\r\n<p>Administered by: Us<\/p>\r\n<p>Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.<\/p>\r\n<\/li>\r\n<\/ul>\r\n<p>For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or the Cookies section of our Privacy Policy.<\/p>\r\n<h2>Use of Your Personal Data<\/h2>\r\n<p>The Company may use Personal Data for the following purposes:<\/p>\r\n<ul>\r\n<li>\r\n<p><strong>To provide and maintain our Service<\/strong>, including to monitor the usage of our Service.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>To manage Your Account:<\/strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>For the performance of a contract:<\/strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>To contact You:<\/strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>To provide You<\/strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>To manage Your requests:<\/strong> To attend and manage Your requests to Us.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>For business transfers:<\/strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.<\/p>\r\n<\/li>\r\n<li>\r\n<p><strong>For other purposes<\/strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.<\/p>\r\n<\/li>\r\n<\/ul>\r\n<p>We may share Your personal information in the following situations:<\/p>\r\n<ul>\r\n<li><strong>With Service Providers:<\/strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.<\/li>\r\n<li><strong>For business transfers:<\/strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.<\/li>\r\n<li><strong>With Affiliates:<\/strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.<\/li>\r\n<li><strong>With business partners:<\/strong> We may share Your information with Our business partners to offer You certain products, services or promotions.<\/li>\r\n<li><strong>With other users:<\/strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside. If You interact with other users or register through a Third-Party Social Media Service, Your contacts on the Third-Party Social Media Service may see Your name, profile, pictures and description of Your activity. Similarly, other users will be able to view descriptions of Your activity, communicate with You and view Your profile.<\/li>\r\n<li><strong>With Your consent<\/strong>: We may disclose Your personal information for any other purpose with Your consent.<\/li>\r\n<\/ul>\r\n<h2>Retention of Your Personal Data<\/h2>\r\n<p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.<\/p>\r\n<p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.<\/p>\r\n<h2>Transfer of Your Personal Data<\/h2>\r\n<p>Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to \u2014 and maintained on \u2014 computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.<\/p>\r\n<p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.<\/p>\r\n<p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.<\/p>\r\n<h2>Delete Your Personal Data<\/h2>\r\n<p>You have the right to delete or request that We assist in deleting the Personal Data that We have collected about You.<\/p>\r\n<p>Our Service may give You the ability to delete certain information about You from within the Service.<\/p>\r\n<p>You may update, amend, or delete Your information at any time by signing in to Your Account, if you have one, and visiting the account settings section that allows you to manage Your personal information. You may also contact Us to request access to, correct, or delete any personal information that You have provided to Us.<\/p>\r\n<p>Please note, however, that We may need to retain certain information when we have a legal obligation or lawful basis to do so.<\/p>\r\n<h2>Disclosure of Your Personal Data<\/h2>\r\n<h3>Business Transactions<\/h3>\r\n<p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.<\/p>\r\n<h3>Law enforcement<\/h3>\r\n<p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).<\/p>\r\n<h3>Other legal requirements<\/h3>\r\n<p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:<\/p>\r\n<ul>\r\n<li>Comply with a legal obligation<\/li>\r\n<li>Protect and defend the rights or property of the Company<\/li>\r\n<li>Prevent or investigate possible wrongdoing in connection with the Service<\/li>\r\n<li>Protect the personal safety of Users of the Service or the public<\/li>\r\n<li>Protect against legal liability<\/li>\r\n<\/ul>\r\n<h2>Security of Your Personal Data<\/h2>\r\n<p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.<\/p>\r\n<h1>Children\'s Privacy<\/h1>\r\n<p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.<\/p>\r\n<p>If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.<\/p>\r\n<h1>Links to Other Websites<\/h1>\r\n<p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.<\/p>\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.<\/p>\r\n<h1>Changes to this Privacy Policy<\/h1>\r\n<p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.<\/p>\r\n<p>We will let You know via email and\/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.<\/p>\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.<\/p>\r\n<h1>Contact Us<\/h1>\r\n<p>If you have any questions about this Privacy Policy, You can contact us:<\/p>\r\n<ul>\r\n<li>\r\n<p>By email: <a href=\"mailto:info@smart-fish-bd.com\" title=\"Mail to : info@smart-fish-bd.com\">info@smart-fish-bd.com</a> <\/p>\r\n<\/li>\r\n<li>\r\n<p>By visiting this page on our website: <a href=\"http:\/\/www.smart-fish-bd.com\/contact-us\" title=\"Contact us\" rel=\"external nofollow noopener\" target=\"_blank\">http:\/\/www.smart-fish-bd.com\/contact-us<\/a><\/p>\r\n<\/li>\r\n<\/ul>\r\n<\/div>\r\n<\/div>\r\n<\/div>"}]',
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Privacy Policy',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        'name'  => 'title',
                        'label' => 'Title',
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'description',
                        'label' => 'Description',
                        'type'  => 'ckeditor',
                    ],
                ],
                'min_rows'  => 1,
                'max_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    3 =>
        array(
            'id'          => 4,
            'key'         => 'terms_of_condition',
            'name'        => 'Terms of Condition',
            'description' => 'Terms of Condition',
            'value'       => '[{"title":"Terms and Conditions","description":"<p>Welcome to smart-fish-bd!<\/p>\r\n\r\n<p>These terms and conditions outline the rules and regulations for the use of smart-fish-bd&#39;s Website, located at https:\/\/www.smart-fish-bd.com.<\/p>\r\n\r\n<p>By accessing this website we assume you accept these terms and conditions. Do not continue to use smart-fish-bd if you do not agree to take all of the terms and conditions stated on this page.<\/p>\r\n\r\n<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: &quot;Client&quot;, &quot;You&quot; and &quot;Your&quot; refers to you, the person log on this website and compliant to the Company&rsquo;s terms and conditions. &quot;The Company&quot;, &quot;Ourselves&quot;, &quot;We&quot;, &quot;Our&quot; and &quot;Us&quot;, refers to our Company. &quot;Party&quot;, &quot;Parties&quot;, or &quot;Us&quot;, refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client&rsquo;s needs in respect of provision of the Company&rsquo;s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and\/or he\/she or they, are taken as interchangeable and therefore as referring to same.<\/p>\r\n\r\n<h3><strong>Cookies<\/strong><\/h3>\r\n\r\n<p>We employ the use of cookies. By accessing smart-fish-bd, you agreed to use cookies in agreement with the smart-fish-bd&#39;s Privacy Policy.<\/p>\r\n\r\n<p>Most interactive websites use cookies to let us retrieve the user&rsquo;s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate\/advertising partners may also use cookies.<\/p>\r\n\r\n<h3><strong>License<\/strong><\/h3>\r\n\r\n<p>Unless otherwise stated, smart-fish-bd and\/or its licensors own the intellectual property rights for all material on smart-fish-bd. All intellectual property rights are reserved. You may access this from smart-fish-bd for your own personal use subjected to restrictions set in these terms and conditions.<\/p>\r\n\r\n<p>You must not:<\/p>\r\n\r\n<ul>\r\n\t<li>Republish material from smart-fish-bd<\/li>\r\n\t<li>Sell, rent or sub-license material from smart-fish-bd<\/li>\r\n\t<li>Reproduce, duplicate or copy material from smart-fish-bd<\/li>\r\n\t<li>Redistribute content from smart-fish-bd<\/li>\r\n<\/ul>\r\n\r\n<p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href=\"https:\/\/www.termsandconditionsgenerator.com\/\">Free Terms and Conditions Generator<\/a>.<\/p>\r\n\r\n<p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. smart-fish-bd does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of smart-fish-bd,its agents and\/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, smart-fish-bd shall not be liable for the Comments or for any liability, damages or expenses caused and\/or suffered as a result of any use of and\/or posting of and\/or appearance of the Comments on this website.<\/p>\r\n\r\n<p>smart-fish-bd reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.<\/p>\r\n\r\n<p>You warrant and represent that:<\/p>\r\n\r\n<ul>\r\n\t<li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;<\/li>\r\n\t<li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;<\/li>\r\n\t<li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy<\/li>\r\n\t<li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.<\/li>\r\n<\/ul>\r\n\r\n<p>You hereby grant smart-fish-bd a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.<\/p>\r\n\r\n<h3><strong>Hyperlinking to our Content<\/strong><\/h3>\r\n\r\n<p>The following organizations may link to our Website without prior written approval:<\/p>\r\n\r\n<ul>\r\n\t<li>Government agencies;<\/li>\r\n\t<li>Search engines;<\/li>\r\n\t<li>News organizations;<\/li>\r\n\t<li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and<\/li>\r\n\t<li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.<\/li>\r\n<\/ul>\r\n\r\n<p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and\/or services; and (c) fits within the context of the linking party&rsquo;s site.<\/p>\r\n\r\n<p>We may consider and approve other link requests from the following types of organizations:<\/p>\r\n\r\n<ul>\r\n\t<li>commonly-known consumer and\/or business information sources;<\/li>\r\n\t<li>dot.com community sites;<\/li>\r\n\t<li>associations or other groups representing charities;<\/li>\r\n\t<li>online directory distributors;<\/li>\r\n\t<li>internet portals;<\/li>\r\n\t<li>accounting, law and consulting firms; and<\/li>\r\n\t<li>educational institutions and trade associations.<\/li>\r\n<\/ul>\r\n\r\n<p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of smart-fish-bd; and (d) the link is in the context of general resource information.<\/p>\r\n\r\n<p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party&rsquo;s site.<\/p>\r\n\r\n<p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to smart-fish-bd. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.<\/p>\r\n\r\n<p>Approved organizations may hyperlink to our Website as follows:<\/p>\r\n\r\n<ul>\r\n\t<li>By use of our corporate name; or<\/li>\r\n\t<li>By use of the uniform resource locator being linked to; or<\/li>\r\n\t<li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party&rsquo;s site.<\/li>\r\n<\/ul>\r\n\r\n<p>No use of smart-fish-bd&#39;s logo or other artwork will be allowed for linking absent a trademark license agreement.<\/p>\r\n\r\n<h3><strong>iFrames<\/strong><\/h3>\r\n\r\n<p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.<\/p>\r\n\r\n<h3><strong>Content Liability<\/strong><\/h3>\r\n\r\n<p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.<\/p>\r\n\r\n<h3><strong>Your Privacy<\/strong><\/h3>\r\n\r\n<p>Please read Privacy Policy<\/p>\r\n\r\n<h3><strong>Reservation of Rights<\/strong><\/h3>\r\n\r\n<p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it&rsquo;s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.<\/p>\r\n\r\n<h3><strong>Removal of links from our website<\/strong><\/h3>\r\n\r\n<p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.<\/p>\r\n\r\n<p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.<\/p>\r\n\r\n<h3><strong>Disclaimer<\/strong><\/h3>\r\n\r\n<p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:<\/p>\r\n\r\n<ul>\r\n\t<li>limit or exclude our or your liability for death or personal injury;<\/li>\r\n\t<li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;<\/li>\r\n\t<li>limit any of our or your liabilities in any way that is not permitted under applicable law; or<\/li>\r\n\t<li>exclude any of our or your liabilities that may not be excluded under applicable law.<\/li>\r\n<\/ul>\r\n\r\n<p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.<\/p>\r\n\r\n<p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.<\/p>"}]',
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Terms of Condition',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        'name'  => 'title',
                        'label' => 'Title',
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'description',
                        'label' => 'Description',
                        'type'  => 'ckeditor',
                    ],
                ],
                'min_rows'  => 1,
                'max_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    4 =>
        array(
            'id'          => 5,
            'key'         => 'banner_images',
            'name'        => 'Banner Images',
            'description' => 'Top Banner Images of Smart Fish BD',
            'value'       => "[\"uploads\\\\banners\\\\banner-1.jpg\",\"uploads\\\\banners\\\\banner-2.jpg\",\"uploads\\\\banners\\\\banner-3.jpg\",\"uploads\\\\banners\\\\banner-4.jpg\"]",
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Banner Images',
                'type'      => 'browse_multiple',
                'min_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    5 =>
        array(
            'id'          => 6,
            'key'         => 'welcome_message',
            'name'        => 'Welcome Message',
            'description' => 'Welcome Message of Smart Fish BD',
            'value'       => '<p>Welcome to Smart Fish BD, where innovation swims with purpose! Established in 2024, we are a team of brilliant minds, including scientists, engineers, software, and mobile app developers, dedicated to revolutionizing the fisheries industry across our country. Dive into our platform to discover cutting-edge solutions aimed at creating a smarter, more sustainable future for fishery management. Join us in our mission to harness technology and expertise to ensure the prosperity of our aquatic resources. Together, let&#39;s pave the way for a brighter tomorrow for both fishermen and fish alike.</p>',
            'field'       => json_encode([
                'name'  => 'value',
                'label' => 'Welcome Message',
                'type'  => 'ckeditor',
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    6 =>
        array(
            'id'          => 7,
            'key'         => 'services',
            'name'        => 'Services',
            'description' => 'Services',
            'value'       => '[{"title":"Fishery Automation","image":"uploads\/services\/banner-1.jpg","description":"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Full System Automation","image":"uploads\/services\/banner-2.jpg","description":"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Software Solution","image":"uploads\/services\/banner-3.jpg","description":"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Mobile Application","image":"uploads\/services\/banner-4.jpg","description":"Welcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."}]',
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Services',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        'name'  => 'title',
                        'label' => 'Title',
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'image',
                        'label' => 'Image',
                        'type'  => 'browse',
                    ],
                    [
                        'name'       => 'description',
                        'label'      => 'Description',
                        'type'       => 'textarea',
                        'attributes' => [
                            'rows' => '4'
                        ],
                    ],
                ],
                'min_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    7 =>
        array(
            'id'          => 8,
            'key'         => 'teams',
            'name'        => 'Teams',
            'description' => 'Our Team',
            'value'       => '[{"name":"Mr. Juwel Ahmed","image":"uploads\/teams\/download.png","designation":"Consultant"},{"name":"Mr. Roni Saha","image":"uploads\/teams\/download.png","designation":"Consultant"},{"name":"Engr. Mehedi Hasan","image":"uploads\/teams\/download.png","designation":"Team Coordinator"},{"name":"Engr. Erfan Mahmud Tushar","image":"uploads\/teams\/download.png","designation":"IOT Engineer"},{"name":"Engr. Ekramul Islam Sumon","image":"uploads\/teams\/download.png","designation":"Software Developer"},{"name":"Engr. Haraprashad Bishwas Niloy","image":"uploads\/teams\/download.png","designation":"Mobile App Developer"}]',
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Teams',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        'name'  => 'name',
                        'label' => 'Name',
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'image',
                        'label' => 'Image',
                        'type'  => 'browse',
                        'hint'  => 'Image size should be 1:1 ratio',
                    ],
                    [
                        'name'    => 'designation',
                        'label'   => 'Designation',
                        'type'    => 'select_from_array',
                        'options' => [
                            'Consultant'           => 'Consultant',
                            'Team Coordinator'     => 'Team Coordinator',
                            'IOT Engineer'         => 'IOT Engineer',
                            'Software Developer'   => 'Software Developer',
                            'Mobile App Developer' => 'Mobile App Developer',
                        ],
                    ],
                ],
                'min_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    8 =>
        array(
            'id'          => 9,
            'key'         => 'products',
            'name'        => 'Products',
            'description' => 'Product List',
            'value'       => '[{"title":"Automated Feeding Solutions - 1","image":"uploads\/products\/product-1.jpg","description":"Automated Feeding Solutions - 1\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions - 2","image":"uploads\/products\/product-2.jpg","description":"Automated Feeding Solutions - 2\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions - 3","image":"uploads\/products\/product-3.jpg","description":"Automated Feeding Solutions - 3\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions - 4","image":"uploads\/products\/product-4.jpg","description":"Automated Feeding Solutions - 4\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions-5","image":"uploads\/products\/product-5.jpg","description":"Automated Feeding Solutions-5\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions-6","image":"uploads\/products\/product-6.jpg","description":"Automated Feeding Solutions-6\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions-7","image":"uploads\/products\/product-7.jpg","description":"Automated Feeding Solutions-7\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."},{"title":"Automated Feeding Solutions-8","image":"uploads\/products\/product-8.jpg","description":"Automated Feeding Solutions-8\r\n\r\nWelcome to Smart Fish, where innovation meets aquatic excellence. Our mission is to revolutionize the way people experience and interact with fishkeeping. As avid enthusiasts of marine life, we understand the importance of creating a harmonious environment for both fish and their owners.\r\n\r\nAt Smart Fish, we leverage cutting-edge technology to bring you intelligent solutions for fish care. Whether you\'re a seasoned aquarist or just starting, our products are designed to make fish keeping not only enjoyable but also sustainable.\r\n\r\nOur team of marine biologists, engineers, and designers work collaboratively to develop state-of-the-art devices that monitor and optimize the conditions of your aquarium. From smart feeders to water quality sensors, we have everything you need to ensure the well-being of your aquatic companions.\r\n\r\nJoin us on this journey as we strive to create a world where fishkeeping is not just a hobby but a seamless integration of nature and technology. Explore the Smart Fish experience and discover a new era in aquatic living."}]',
            'field'       => json_encode([
                'name'      => 'value',
                'label'     => 'Services',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        'name'  => 'title',
                        'label' => 'Title',
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'image',
                        'label' => 'Image',
                        'type'  => 'browse',
                    ],
                    [
                        'name'       => 'description',
                        'label'      => 'Description',
                        'type'       => 'textarea',
                        'attributes' => [
                            'rows' => '4'
                        ],
                    ],
                ],
                'min_rows'  => 1,
                'init_rows' => 1,
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
    9 =>
        array(
            'id'          => 10,
            'key'         => 'app_link',
            'name'        => 'App Link',
            'description' => 'Mobile app Link',
            'value'       => 'https://play.google.com/store/apps/details?id=com.smartfishbd',
            'field'       => json_encode([
                'name'  => 'value',
                'label' => 'App Link',
                'type'  => 'text',
            ]),
            'active'      => 1,
            'created_at'  => NULL,
            'updated_at'  => NULL,
        ),
);
return $settings;
