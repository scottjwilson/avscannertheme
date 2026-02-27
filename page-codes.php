<?php
/**
 * Page Template: Scanner Codes
 *
 * Auto-applies to pages with slug "codes" via WordPress page-{slug}.php hierarchy.
 *
 * @package AVScannerTheme
 */

get_header();

$radio_codes = [
    '187'    => 'Murder',
    '207'    => 'Kidnapping',
    '211'    => 'Robbery',
    '211S'   => 'Robbery Alarm-Silent',
    '215'    => 'Carjacking',
    '242'    => 'Battery',
    '245'    => 'Assault with a Deadly Weapon',
    '246'    => 'Shooting at an Inhabited Dwelling',
    '261'    => 'Rape',
    '273A'   => 'Child Abuse',
    '273.5'  => 'Felony Spousal Assault',
    '288'    => 'Sex Crimes Against Children',
    '314'    => 'Indecent Exposure',
    '330'    => 'Gambling',
    '368'    => 'Elderly Abuse',
    '374B'   => 'Illegal Dumping',
    '390'    => 'Drunk',
    '390P'   => 'Possible Use of PCP',
    '415'    => 'Disturbance',
    '415B'   => 'Disturbance-Business',
    '415D'   => 'Disturbance-Drunk',
    '415E'   => 'Disturbance-Music or Party',
    '415FT'  => 'Disturbance-Fight',
    '415G'   => 'Disturbance-Gang Activity',
    '415J'   => 'Disturbance-Juveniles',
    '415LT'  => 'Disturbance-Landlord/Tenant',
    '415N'   => 'Disturbance-Neighbors',
    '417'    => 'Person with a Gun',
    '417A'   => 'Person with a Knife',
    '417B'   => 'Barricaded Suspect',
    '417BH'  => 'Barricaded Suspect-Hostage Situation',
    '417S'   => 'Shots Fired',
    '422'    => 'Terrorist Threats',
    '451'    => 'Arson',
    '459'    => 'Burglary',
    '459A'   => 'Burglary Alarm-Audible',
    '459S'   => 'Burglary Alarm-Silent',
    '470'    => 'Forgery',
    '480'    => 'Hit and Run-Felony',
    '481'    => 'Hit and Run-Misdemeanor',
    '483'    => 'Hit and Run-Parked Vehicle',
    '487'    => 'Grand Theft',
    '488'    => 'Petty Theft',
    '496'    => 'Receiving Stolen Property',
    '502'    => 'Drunk Driving',
    '503'    => 'Vehicle Theft',
    '503A'   => 'Recovered Vehicle',
    '504'    => 'Tampering with Vehicle',
    '504A'   => 'Vehicle Stripping',
    '510'    => 'Speeding or Racing',
    '537'    => 'Defrauding an Innkeeper',
    '586'    => 'Illegal Parking',
    '586D'   => 'Illegal Parking-Driveway',
    '586F'   => 'Illegal Parking-Fire Hydrant',
    '586H'   => 'Illegal Parking-Handicap',
    '594'    => 'Vandalism',
    '602'    => 'Trespassing',
    '604'    => 'Throwing Objects',
    '646.9'  => 'Stalking',
    '647.6'  => 'Person Annoying/Molesting Children',
    '653M'   => 'Lewd or Threatening Phone Call',
    '901N'   => 'Ambulance Needed',
    '901S'   => 'Person Sick or Injured-Ambulance Dispatched',
    '901T'   => 'Traffic Collision-Ambulance Dispatched',
    '902'    => 'Person Sick or Injured',
    '902A'   => 'Attempt Suicide',
    '902H'   => 'Enroute to Hospital',
    '902N'   => 'Traffic Collision-No Injuries',
    '902R'   => 'Rescue Responding',
    '902T'   => 'Traffic Collision-Unknown if Injuries',
    '903'    => 'Aircraft Accident',
    '903L'   => 'Low Flying Aircraft',
    '904'    => 'Fire',
    '904A'   => 'Fire-Auto',
    '904B'   => 'Fire-Brush or Grass',
    '904I'   => 'Smoke Investigation',
    '904S'   => 'Fire-Structure',
    '904T'   => 'Fire-Trash',
    '905A'   => 'Abuse to Animals',
    '905B'   => 'Animal-Bite',
    '905D'   => 'Animal-Dead',
    '905N'   => 'Animal-Noisy',
    '905S'   => 'Animal-Stray',
    '905V'   => 'Animal-Vicious',
    '909'    => 'Traffic Stop',
    '909A'   => 'Wires Down',
    '909C'   => 'Child Locked in Vehicle',
    '909M'   => 'Monitoring Traffic',
    '909R'   => 'Radar Enforcement',
    '909S'   => 'Safety Hazard',
    '909T'   => 'Traffic Hazard',
    '911A'   => 'Contact Informant',
    '911B'   => 'Contact Officer',
    '911C'   => 'Citizen Contact',
    '911N'   => 'Do not Contact Informant',
    '912'    => 'Are we Clear?',
    '913'    => 'You are Clear',
    '914C'   => 'CHP Notified',
    '914F'   => 'Fire Department Notified',
    '914N'   => 'Concerned Party Noticed',
    '916'    => 'Officer Holding Misdemeanor Suspect',
    '916A'   => 'Officer Holding Felony Suspect',
    '916B'   => 'Citizen Holding Misdemeanor Suspect',
    '916C'   => 'Citizen Holding Felony Suspect',
    '917A'   => 'Abandoned Vehicle',
    '917S'   => 'Suspicious Vehicle',
    '918'    => 'Insane Person',
    '918V'   => 'Violently Insane Person',
    '919'    => 'Keep the Peace',
    '920'    => 'Missing Person',
    '920C'   => 'Missing Critical',
    '920F'   => 'Found Adult/Juvenile',
    '921'    => 'Prowler',
    '922'    => 'Illegal Peddling',
    '923'    => 'Illegal Shooting',
    '924'    => 'Station Detail',
    '924B'   => 'Briefing, Vehicle Prep/Exchange/Trouble Eos',
    '924C'   => 'Court Appearance',
    '924M'   => 'Messenger Service',
    '924P'   => 'Patrol Check',
    '925'    => 'Person Acting Suspiciously',
    '925A'   => 'Person Acting Suspiciously In Vehicle',
    '926'    => 'Tow Truck Requested',
    '926A'   => 'Tow Truck Dispatched',
    '927'    => 'Suspicious Circumstances',
    '927A'   => 'Suspicious Circumstances-Person Pulled from Phone',
    '927B'   => 'Suspicious Circumstances-Open Door or Window',
    '927C'   => 'Check Vicinity',
    '927D'   => 'Suspicious Circumstances-Possible Dead Body',
    '927H'   => '9-1-1 Hang Up',
    '927P'   => 'Suspicious Circumstances-Panic Alarm',
    '927S'   => 'Suspicious Circumstances-Person Screaming',
    '928'    => 'Found Property',
    '928L'   => 'Lost Property',
    '929'    => 'Person Down',
    '930'    => 'See the Man',
    '930A'   => 'See the Manager',
    '931'    => 'See the Woman',
    '962'    => "Levy Completed w/o Defendant's Knowledge",
    '963'    => "Levy Completed w/ Defendant's Knowledge",
    '964'    => 'Eviction',
    '995'    => 'Strike Trouble',
    '996'    => 'Explosion',
    '996T'   => 'Bomb Threat',
    '997'    => 'Deputy Needs Help Urgently-District Cars Only Five Units with Shortest ETA',
    '998'    => 'Deputy Involved in Shooting',
    '999'    => 'Deputy Needs Help Urgently-All Units Respond',
];

$standard_codes = [
    'Code 1'   => 'Acknowledge receipt of message',
    'Code 1M'  => 'Monitor your MDT',
    'Code 1B'  => 'Clear your MDT buffer',
    'Code 3'   => 'Emergency, Use red lights and siren',
    'Code 4'   => 'No further assistance needed',
    'Code 4A'  => 'Situation is not secure, sufficient units at location',
    'Code 4N'  => 'No assistance needed. No evidence of crime at location.',
    'Code 5'   => 'Stake out. All units stay away, unless emergency call.',
    'Code 6'   => 'Out for investigation',
    'Code 7'   => 'Out of service to eat',
    'Code 8'   => 'Fire Alarm',
    'Code 9'   => 'Following only',
    'Code 14'  => 'Resume normal operations',
    'Code 20'  => 'Notify news media',
    'Code 77'  => 'Possible ambush, Use caution.',
    'Code 77N' => 'No answer at call back. Use caution.',
];

$ten_codes = [
    '10-1'   => 'Receiving poorly',
    '10-2'   => 'Receiving well',
    '10-3'   => 'Stop transmitting',
    '10-4'   => 'Acknowledged',
    '10-5'   => 'Relay',
    '10-6'   => 'Busy',
    '10-7'   => 'Out of service',
    '10-8'   => 'In service',
    '10-9'   => 'Repeat',
    '10-10'  => 'Out of vehicle, subject to call',
    '10-11'  => 'Transmitting too Rapidly',
    '10-13'  => 'Advise Weather and Road Conditions',
    '10-15'  => 'Prisoner in Custody',
    '10-16'  => 'Pick Up Prisoner',
    '10-17'  => 'Pick Up Papers',
    '10-17A' => 'Are you Holding Papers?',
    '10-19'  => 'Return to Indicated Location',
    '10-20'  => 'Location',
    '10-21'  => 'Telephone Indicated Location',
    '10-22'  => 'Cancel',
    '10-23'  => 'Stand By',
    '10-27'  => 'Any Return on Number or Subject?',
    '10-28'  => 'Vehicle Registration/Wants (Complete)',
    '10-29'  => 'Vehicle Registration/Wants (Summary)',
    '10-29F' => 'SJ is Wanted for a Felony, Use caution',
    '10-29H' => 'Are you Clear to Copy Confidential Information?',
    '10-29M' => 'Subject is Wanted for a Misdemeanor Crime',
    '10-29P' => 'Subject is parolee, probationer, career criminal, registered sex offender, or registered arsonist',
    '10-29T' => 'Subject is Wanted for a Traffic Warrant',
    '10-29V' => 'Property Reported Stolen',
    '10-30'  => 'Transmission does not Conform to Regulations',
    '10-31'  => 'Request Unit and Channel',
    '10-33'  => 'Request Emergency Clearance',
    '10-34'  => 'Request Routine Clearance',
    '10-36'  => 'Correct Time',
    '10-37'  => 'Identify Operator',
    '10-38'  => 'Request Clearance to Run a Subject',
    '10-39'  => 'Request to Clear an Incident',
    '10-97'  => 'Arrived at Scene',
    '10-98'  => 'Finished Assignment',
];

$sections = [
    'radio'    => ['title' => 'Radio Codes',    'codes' => $radio_codes],
    'standard' => ['title' => 'Standard Codes',  'codes' => $standard_codes],
    'ten'      => ['title' => 'Ten Codes',        'codes' => $ten_codes],
];
?>

<section class="hero" style="padding-bottom: 2rem;">
    <div class="container">
        <div class="hero-content">
            <h1 class="text-hero">Scanner Codes</h1>
            <p class="hero-subtitle">Complete reference for radio, standard, and ten codes used by law enforcement and emergency services in the Antelope Valley.</p>
        </div>
    </div>
</section>

<section class="section codes-page" style="padding-top: 2rem;">
    <div class="container">

        <!-- Search -->
        <div class="codes-search-wrap">
            <div class="codes-search">
                <?php echo avs_icon('search', 18); ?>
                <input type="text"
                       id="codes-search-input"
                       class="codes-search-input"
                       placeholder="Search codes (e.g. 415, burglary, 10-4)..."
                       autocomplete="off">
            </div>
            <span class="codes-match-count" id="codes-match-count" hidden></span>
        </div>

        <!-- Local Numbers -->
        <div class="codes-local-numbers">
            <h2 class="codes-section-title">Local Numbers</h2>
            <div class="codes-local-grid">
                <a href="mailto:admin@avscannernews.com" class="codes-local-item">
                    <?php echo avs_icon('mail', 16); ?>
                    <span class="codes-local-name">Email</span>
                    <span class="codes-local-value">admin@avscannernews.com</span>
                </a>
                <a href="tel:+16612675100" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">City of Palmdale</span>
                    <span class="codes-local-value">(661) 267-5100</span>
                </a>
                <a href="tel:+16617236000" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">City of Lancaster</span>
                    <span class="codes-local-value">(661) 723-6000</span>
                </a>
                <a href="tel:+16612722400" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">Palmdale Sheriff</span>
                    <span class="codes-local-value">(661) 272-2400</span>
                </a>
                <a href="tel:+16619488466" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">Lancaster Sheriff</span>
                    <span class="codes-local-value">(661) 948-8466</span>
                </a>
                <a href="tel:+16619488541" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">CHP Antelope Valley</span>
                    <span class="codes-local-value">(661) 948-8541</span>
                </a>
                <a href="tel:+13232593200" class="codes-local-item">
                    <?php echo avs_icon('phone', 16); ?>
                    <span class="codes-local-name">CHP After Hours</span>
                    <span class="codes-local-value">(323) 259-3200</span>
                </a>
            </div>
        </div>

        <!-- Section Nav -->
        <nav class="codes-nav" aria-label="Code sections">
            <?php foreach ($sections as $key => $section): ?>
                <a href="#<?php echo esc_attr($key); ?>"
                   class="codes-nav-tab"
                   data-section="<?php echo esc_attr($key); ?>">
                    <?php echo esc_html($section['title']); ?>
                    <span class="codes-nav-count"><?php echo count($section['codes']); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Code Sections -->
        <?php foreach ($sections as $key => $section): ?>
            <div class="codes-section" id="<?php echo esc_attr($key); ?>" data-section="<?php echo esc_attr($key); ?>">
                <h2 class="codes-section-title"><?php echo esc_html($section['title']); ?></h2>
                <div class="codes-grid">
                    <?php foreach ($section['codes'] as $code => $desc): ?>
                        <div class="codes-row"
                             data-code="<?php echo esc_attr(strtolower($code)); ?>"
                             data-desc="<?php echo esc_attr(strtolower($desc)); ?>">
                            <span class="codes-code"><?php echo esc_html($code); ?></span>
                            <span class="codes-desc"><?php echo esc_html($desc); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Empty State -->
        <div class="codes-empty" id="codes-empty" hidden>
            <?php echo avs_empty_state_svg('no-results'); ?>
            <h3>No codes found</h3>
            <p>Try a different search term or browse sections above.</p>
        </div>

    </div>
</section>

<?php get_footer(); ?>
