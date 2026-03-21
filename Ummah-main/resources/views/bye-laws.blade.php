<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bye-Laws - NSUK Ummah Multi-Purpose Cooperative Society</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #006B54 0%, #C9A961 100%); }
        .text-gold { color: #C9A961; }
        .text-army-green { color: #006B54; }
        .bg-army-green { background-color: #006B54; }
        .bg-gold { background-color: #C9A961; }
        
        /* Typography for Bye-Laws */
        .legal-content h2 { color: #006B54; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; text-transform: uppercase; font-size: 1.5rem; border-bottom: 2px solid #C9A961; padding-bottom: 0.5rem; display: inline-block; }
        .legal-content h3 { color: #2d3748; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; font-size: 1.1rem; }
        .legal-content p { margin-bottom: 1rem; line-height: 1.8; color: #4a5568; text-align: justify; }
        .legal-content ul, .legal-content ol { margin-bottom: 1rem; margin-left: 1.5rem; }
        .legal-content li { margin-bottom: 0.5rem; line-height: 1.6; color: #4a5568; }
        .legal-content .section-number { color: #C9A961; margin-right: 0.5rem; }
    </style>
</head>
<body class="antialiased bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-transparent.png') }}" alt="NUMCSU Logo" class="h-12 w-auto">
                    <div class="hidden sm:block">
                        <span class="block text-army-green font-black text-lg leading-none">NUMCSU</span>
                        <span class="block text-gold font-bold text-[9px] tracking-widest uppercase">Digital Cooperative</span>
                    </div>
                </a>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-army-green font-bold hover:text-gold transition text-sm">Back to Home</a>
                    <a href="{{ route('join.step1') }}" class="px-5 py-2 bg-gold text-white font-bold rounded-lg hover:bg-opacity-90 transition shadow-md text-sm">Join Now</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="relative bg-army-green py-20 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1577415124269-fc1140a69e91?auto=format&fit=crop&q=80&w=2000')] bg-cover bg-center opacity-10"></div>
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center text-white">
            <p class="text-gold font-bold tracking-[0.3em] uppercase mb-4">Official Document</p>
            <h1 class="text-4xl md:text-5xl font-black mb-6">COOPERATIVE BYE-LAWS</h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto">The guiding principles and regulations of NSUK Ummah Multi-Purpose Cooperative Society (NUMCS).</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-10 relative z-20">
        <div class="bg-white rounded-[32px] shadow-xl p-8 md:p-12 legal-content">
            
            <!-- Cover Page Info -->
            <div class="text-center border-b-2 border-gray-100 pb-12 mb-12">
                <h2 class="!border-none !text-3xl !mt-0">NSUK UMMAH</h2>
                <p class="font-black text-xl text-gray-800 uppercase tracking-wide mb-2">MULTIPURPOSE COOPERATIVE SOCIETY (NUMCS)</p>
                <p class="text-army-green font-bold text-lg mb-8">(ZERO INTEREST BASED)</p>
                
                <p class="font-bold text-gray-700">MUSLIM COMMUNITY</p>
                <p class="font-bold text-gray-700">NASARAWA STATE UNIVERSITY, KEFFI.</p>
            </div>

            <!-- Section One -->
            <div id="section-one" class="mb-12">
                <h2><span class="section-number">1.0</span> PREAMBLE</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.1</span>
                        <p>We hereby affirm our recognition that mankind is created by Allah (SWT) and that every human effort should be geared towards establishing His authority on the surface of the earth.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.2</span>
                        <p>We recognize that Allah (SWT) permits productive enterprises of trade (which engenders mutual benefits) but forbids interest (which engenders accumulation of wealth in the hands of a few and impoverishment of the majority) as contained in <strong>Qur'an 2:275-278</strong>.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.3</span>
                        <p>We recognize the advantage of co-operation in advancing individuals as well as the collective goal of mankind generally and the Muslim Ummah in particular.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.4</span>
                        <p>We recognize also that divine principles regulating economic co-operation emphasize justice, equity, transparency, fairness and avoiding injury to mankind (self, others and society) as provided in <strong>Qur'an 2:188</strong>.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.5</span>
                        <p>We affirm the rights of the less privileged to the wealth of the privileged through the institution of <em>Zakaat</em> as provided in <strong>Qur'an 2:277</strong>.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">1.6</span>
                        <p>We do hereby form ourselves into a Zero-Interest based Multipurpose Co-operative Society in furtherance of our collective goal of economic empowerment of the Muslim Ummah, specifically registered members of the cooperative in total submission to Almighty Allah, our Creator.</p>
                    </div>
                </div>
            </div>

            <!-- Section Two -->
            <div id="section-two" class="mb-12">
                <h2><span class="section-number">2.0</span> INTERPRETATIONS</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">2.1</span>
                        <div>
                            <p class="mb-4">All words and expressions used in the Bye-laws and defined by the provisions of the Nigeria Co-operative Societies Act, 1993 shall have the meaning assigned to them in the above named section in these Bye-laws as follows:</p>
                            <ol class="list-[lower-alpha] space-y-2 ml-4">
                                <li><strong>Financial Year:</strong> The period of twelve months beginning from 1st January to 31st of December of the same year.</li>
                                <li><strong>Law:</strong> The Nigeria Co-operative Societies Act, 1993.</li>
                                <li><strong>Registrar:</strong> The Registrar of Cooperative Societies of Nasarawa State.</li>
                                <li><strong>Regulations:</strong> Regulations made under the law by the government of Nasarawa State of Nigeria.</li>
                                <li><strong>Management Committee:</strong> The governing body to whom the management of cooperative affairs is entrusted.</li>
                                <li><strong>Member:</strong> Any person admitted to membership after registration in accordance with the byelaws and regulations.</li>
                                <li><strong>Committee:</strong> A nominated body of persons within the society to whom specific duties are delegated by the society.</li>
                                <li><strong>NSUK:</strong> Nasarawa State University, Keffi.</li>
                                <li><strong>Ordinary General Meeting:</strong> This may include Extraordinary or Special or Emergency General Meeting depending on the context especially any duly summoned general meeting outside the statutorily fixed meetings.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Three -->
            <div id="section-three" class="mb-12">
                <h2><span class="section-number">3.0</span> NAME, ADDRESS AND AREAS OF OPERATION</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">3.1</span>
                        <p>The name of the society shall be "NSUK UMMAH MULTIPURPOSE COOPERATIVE SOCIETY (NUMCS) (a Zero interest based Society).</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">3.2</span>
                        <p>The address of the Society shall be: Muslim Community NSUK C/O Central Mosque Nasarawa State University, Keffi, PMB 1022, Keffi, Nasarawa State.</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-bold text-army-green">3.3</span>
                        <p>The area of operation shall be Nasarawa State University, Keffi and its various campuses and outlets.</p>
                    </div>
                </div>
            </div>

            <!-- Section Four -->
            <div id="section-four" class="mb-12">
                <h2><span class="section-number">4.0</span> OBJECTIVES</h2>
                <p class="mb-4">The main objective of the society is to promote economic interest, welfare and wellbeing of its members. The specific objectives include:</p>
                <ol class="list-decimal space-y-4 ml-4">
                    <li>The provision of facilities for regular economic savings and deposits by members.</li>
                    <li>To give interest free emergency loan to members where possible.</li>
                    <li>To engage in any profitable business or investment in line with Islamic principles.</li>
                    <li>To purchase and retail to its members and other members of the University Community, at affordable rates, essential commodities as may be deemed necessary by the Management Committee or as requested by members.</li>
                    <li>To buy, sell, or lease to members of the society and nonmembers; lands, buildings, Vehicles, Electronics, Motor Cycles etc.</li>
                    <li>To undertake any other measure designed on the basis of cooperative principle to encourage among its members the spirit and practice of economic, mutual and self-help.</li>
                </ol>
                <p class="mt-4 font-bold italic">All these objectives shall be carried out under strict Islamic conditions and provisions after satisfying their compliance with the dictates of Shariah.</p>
            </div>

            <!-- Section Five -->
            <div id="section-five" class="mb-12">
                <h2><span class="section-number">5.0</span> MEMBERSHIP AND LIABILITY</h2>
                
                <div class="mb-6">
                    <h3>5.1 MEMBERSHIP AND LIABILITY</h3>
                    <ol class="list-[lower-alpha] space-y-2">
                        <li>Membership shall be confined to only Staff of Nasarawa State University, Keffi.</li>
                        <li>Each member shall pay a non-refundable registration fee of ₦1,000.00 (One Thousand Naira) only which shall be deducted at source from the University payroll (Staff salary).</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>5.2 DECLARATION OF OBLIGATION</h3>
                    <p>A member shall be deemed to have given NUMCS for the compulsory deduction at source (University Payroll) of his/her non-refundable registration fee and a monthly minimum deduction of <strong>One Thousand Naira (₦1, 000) only</strong> for Junior Staff and <strong>Three Thousand Naira (₦3, 000)</strong> for Senior Staff as compulsory savings with the Society except where the amount is increased at the discretion of the member which shall be communicated in writing and by filling the necessary form.</p>
                </div>

                <div class="mb-6">
                    <h3>5.3 BENEFITS OF MEMBERSHIP</h3>
                    <p>Every member of the society is entitled to the following benefits having satisfied all the conditions of membership in accordance with this Bye Law:</p>
                    <ol class="list-[lower-alpha] space-y-2 ml-4">
                        <li>Voting rights at all meetings including rights to vote and be voted for. However, no member shall be voted for any elective post or considered for an appointed post unless he/she has attended at least 1/3 of the Society's meetings.</li>
                        <li>Dividends, bonuses, surpluses etc.; declared and approved by congress at the end of the financial year.</li>
                        <li>Assistance to accident victim(s) while on official duty and in case of death to the family of the deceased.</li>
                        <li>Reimbursement for any duly authorized expenses incurred on behalf of the Society.</li>
                        <li>Stipend stipulated in the Bye Law, as an incentive for holding an elective or appointive post. However, there shall not be salary and or sitting allowance for the Society's meetings but refreshments shall be served.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>5.4 NEXT OF KIN</h3>
                    <p>A member shall provide the name of next of kin to whom his share or savings shall be transferred to in case of incapacitation or death.</p>
                </div>

                <div class="mb-6">
                    <h3>5.5 TERMINATION / CESSATION OF MEMBERSHIP</h3>
                    <p>A person shall cease to be a member of the Society or his/her membership shall be terminated upon the happening of any of the following:</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Death.</li>
                        <li>Permanent disabilities.</li>
                        <li>Conviction for criminal offence or other acts involving dishonesty and resulting in imprisonment or a fine.</li>
                        <li>Retirement from or leaving the services of the University.</li>
                        <li>Expulsion for gross violation of the provisions of the Law.</li>
                        <li>Expulsion by 2/3 majority at a general meeting on moral ground.</li>
                        <li>Completely withdrawing ordinary savings and any other deposits.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>5.6 WITHDRAWAL OF MEMBERSHIP</h3>
                    <p>A member may withdraw his membership from the society after giving a three (3) months' notice to the management of the society in writing provided that:</p>
                    <ol class="list-[lower-alpha] space-y-2 ml-4">
                        <li>He is not a surety or guarantor to any outstanding loan.</li>
                        <li>The withdrawing member shall settle all debts he owed to the society before or upon withdrawal.</li>
                    </ol>
                </div>
            </div>

            <!-- Section Six -->
            <div id="section-six" class="mb-12">
                <h2><span class="section-number">6.0</span> SOURCES OF FUNDS</h2>
                <p>The funds of the Society shall be generated from;</p>
                <ol class="list-decimal space-y-2 ml-4">
                    <li>Registration fee (Non-refundable).</li>
                    <li>Membership savings.</li>
                    <li>Deposits from members for special packages.</li>
                    <li>Surplus arising from business transactions (retained earnings).</li>
                    <li>Proceeds from sale of forms as may be approved by the management committee.</li>
                    <li>Sales of membership pass books, bye-laws etc. to members.</li>
                    <li>Any other sources that is legitimate under Islamic provisions.</li>
                </ol>
            </div>

            <!-- Section Seven -->
            <div id="section-seven" class="mb-12">
                <h2><span class="section-number">7.0</span> POWERS AND DUTIES OF GENERAL MEETING</h2>
                
                <div class="mb-6">
                    <p><strong>a) Ordinary General Meeting (OGM):</strong> An OGM shall be held at least once in six months to review and direct the operations of the Society. Its activities shall include the following:</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Establish standing and ad-hoc committees or ratify Management Committees appointments;</li>
                        <li>Consider the Audit Report and Registrar's of Cooperatives Lafia, Ministry of Trade, Industry and Investment comments thereof unless previously dealt with at the Annual General Meeting.</li>
                        <li>Approve salaries and discipline of employed staff;</li>
                        <li>Dispose of the Society's general matters;</li>
                        <li>Take disciplinary actions on bad debtors and delinquent members including suspension and expulsion in accordance with the Bye Law.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <p><strong>b) Annual General Meeting (AGM):</strong> The AGM shall:</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Receive, consider and approve or disapprove the annual financial reports and accounts of the society prepared by Management Committee;</li>
                        <li>Decide on the disposal or sharing of the net surplus, dividends and bonuses.</li>
                        <li>Consider the election, suspension and or removal of any or all members of the Management Committee.</li>
                        <li>Elect a new Management Committee at the expiration of the Committee's two years tenure subject to another renewal for another two years.</li>
                        <li>Resolve all matters which the requisite notice has been duly served by concerned member(s) in accordance with this Bye-law.</li>
                        <li>Effect necessary amendments to or repeal existing Bye-Law in the best interest of the Society.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <p><strong>c) Emergency General Meeting:</strong> It shall be convened any time by the Management Committee at the following instances:</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>A resolution by 2/3 of the members of the Management Committee.</li>
                        <li>A request signed by 1/5 of the members if membership is less than 100 members or by 25 members if the membership is more than 100 whichever less is. Such meetings shall be convened within one week upon receipt of the request by the statutory required members.</li>
                        <li>If however, the Management Committee fails to convene such meeting within the stipulated period, the members applying for such meetings shall have the right to convene the meeting of the Society and having formed a quorum proceed to make lawful resolutions on the activities of the Society in accordance with this Bye-Law.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <p><strong>d) Quorum for Meeting:</strong> It shall be 1/3 of total members or person.</p>
                </div>
            </div>

            <!-- Section Eight -->
            <div id="section-eight" class="mb-12">
                <h2><span class="section-number">8.0</span> BUSINESS OPERATIONS</h2>
                <ol class="list-[lower-roman] space-y-4 ml-4">
                    <li>Eighty percent (80%) of each member's saving is earmarked for the society's business.</li>
                    <li>Any accepted business proposal from a member, non-member, and an organization shall be carried out on an agreed profit and loss sharing ratio.</li>
                    <li>Investment/loan shall be considered on first come first have basis subject to availability of funds.</li>
                    <li>The Net Profit realized from all business activities within a financial year, shall be distributed in line with the society's bye-law.</li>
                </ol>
            </div>

            <!-- Section Nine -->
            <div id="section-nine" class="mb-12">
                <h2><span class="section-number">9.0</span> MANAGEMENT COMMITTEE AND OTHER COMMITTEES</h2>
                
                <div class="mb-6">
                    <h3>9.1 MANAGEMENT COMMITTEE</h3>
                    <p>These shall be members elected at the Annual General Meeting to manage the affairs of the society, for two financial years and renewable once. It shall comprise of the Chairman, Vice Chairman, Secretary, Assistant Secretary, Treasurer, Financial Secretary, Internal Auditor, P.R.O and 2 Ex-Officio.</p>
                </div>

                <div class="mb-6">
                    <h3>9.2 FUNCTIONS OF THE MANAGEMENT COMMITTEE</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The committee shall meet often as the business of the society may require and in any case not less than one month.</li>
                        <li>Meetings of the committee shall be summoned by the Secretary after due consultation with the Chairman.</li>
                        <li>The committee shall maintain true and fair records of the Cooperative transactions.</li>
                        <li>The committee shall keep a true and fair account of assets and liabilities of society.</li>
                        <li>The committee shall keep on up-to-date register of members.</li>
                        <li>The committee shall prepare and lay before the general meeting once every year an audited accounts of the society.</li>
                        <li>The committee shall enter into contract on behalf of the society, provided the subject matter is <em>Halal</em>.</li>
                        <li>The committee shall have the power to employ and assign duties and responsibilities.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.1 THE CHAIRMAN</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The Chairman shall preside over all meeting of the society.</li>
                        <li>He shall be the chief accounting officer of the society.</li>
                        <li>He shall be the 'A' signatory to the account of the society.</li>
                        <li>He shall sign minute of meetings.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.2 THE VICE CHAIRMAN</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Shall assume all responsibilities of the chairman in case the chairman is not available or as may be directed by the chairman or when the Chairman ceases to be a member in whatever way.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.3 TREASURER</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The treasurer shall take charge of all monies received by and on behalf of the society.</li>
                        <li>He /She shall make disbursement in accordance with the directions of the management committee.</li>
                        <li>He /She shall sign the cash book.</li>
                        <li>He /She shall produce the cash balance whenever called upon to do so by the chairman or at every general meeting.</li>
                        <li>He /She shall deposit all money in his/her possession except the limit fixed by the general meeting in any bank approved for this purpose by the management committee to be ratified by the general meeting. All such monies shall be deposited in the name of the society.</li>
                        <li>Shall be one of the 'B' signatories to the accounts of the society.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.4 THE SECRETARY GENERAL</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The secretary shall keep and maintain correct books records and registers.</li>
                        <li>He /She shall take minutes of all meetings.</li>
                        <li>He /She shall prepare all vouchers and documents required by the regulations or bye-laws or call for the management meeting after consulting the chairman.</li>
                        <li>He /She shall summon and attend all meetings.</li>
                        <li>He /She shall sign on behalf of the society and receive all its correspondences.</li>
                        <li>He /She shall prepare records and proceedings of meetings and have them duly signed.</li>
                        <li>He /She shall make himself available in the office during the hours fixed for him.</li>
                        <li>He /She shall be one of the B signatories to the accounts of the society.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.5 ASSISTANT SECRETARY GENERAL</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>He /She Shall act on behalf of the secretary.</li>
                        <li>He /She Shall assume other roles as may be assigned by the general meetings or management committee, or the secretary from time to time.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.6 FINANCIAL SECRETARY</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The financial secretary shall take charge of all books or financial books and transactions.</li>
                        <li>He /She shall oversee pass books for members and update same accordingly.</li>
                        <li>He /She shall prepare and submit to the management, the annual account, statements of financial transaction.</li>
                        <li>He /She Shall prepare the financial statements for the society and present same to members.</li>
                        <li>He /She shall keep and manage impress as may be approved by the management committee.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.7 INTERNAL AUDITOR</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The internal auditor shall be responsible for the audit of all the books, accounts and all relevant documents of the society for every financial year.</li>
                        <li>He /She shall liaise with the supervisory committee and advise them.</li>
                        <li>He /She shall prepare Auditor's report and submit same to the general meeting.</li>
                        <li>He /She shall carry out other responsibility as may be assigned to him or her by the management committee or the general meeting.</li>
                        <li>He /She shall append his/her signature on the financial statement and accounts for all money received and expended by the society.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.8 PUBLIC RELATION OFFICER</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The Public Relation Officer shall be the image maker of the society.</li>
                        <li>He /She shall arrange for the society's meeting and communicate same to members.</li>
                        <li>He /She shall publicize the activities of the society in consultation with the executive committee.</li>
                        <li>He /She shall be available in the office during the hours fixed for him from time to time.</li>
                        <li>He /She shall be the Publicity Secretary of the Society.</li>
                        <li>He /She shall convey messages to and on behalf of the society or her members.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.2.9 EX-OFFICIO I AND EX-OFFICIO II</h3>
                    <p>The Chairman and the Secretary of the preceding Management Committee shall serve as the ex-officio I and II respectively. They shall attend all executive and general meetings and share their experience with members of the management committee.</p>
                </div>

                <div class="mb-6">
                    <h2><span class="section-number">9.3</span> COMMITTEES</h2>
                    <p>There shall be in place the following standing committee as may be approved by the general meeting.</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Shura Committee;</li>
                        <li>Business/Investment Committee;</li>
                        <li>Audit Committee;</li>
                        <li>Other committees as circumstance might demand and with the approval of the general meeting.</li>
                        <li>Zakaat Committee</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.3.1 THE SHURA COMMITTEE</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The Shura Committee shall comprise of five (5) members none of whom shall be appointed to the executive posts nor be any of the incumbent members of the executives. It shall be constituted at the third quarters of the second year of the tenure of the Management Committee.</li>
                        <li>The Shura Committee shall be appointed by the Management Committee subject to the approval of the EXCO of the Muslim Ummah.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.3.1a DUTIES OF THE SHURA COMMITTEE</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The Shura committee shall provide guidelines for the conduct of appointment into the post of executive officers. A quorum shall consist of 3 members.</li>
                        <li>It shall collect nominations into various offices during the third quarter general meeting.</li>
                        <li>It shall conduct interview for nominees between the third quarters and the annual general meetings.</li>
                        <li>It shall submit report of activities of the Shura and hence announce the names of the newly appointed members of the management and other committees.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.3.2 BUSINESS/INVESTMENT COMMITTEE</h3>
                    <p>The Business Committee shall consist of 5 members nominated for 2 years at the annual general meeting. A quorum shall consist of 3 members.</p>
                </div>

                <div class="mb-6">
                    <h3>9.3.2a DUTIES OF THE BUSINESS/INVESTMENT COMMITTEE</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The business committee shall identify lawful and viable investment opportunities for the society.</li>
                        <li>It shall prepare a business plan for the short, medium and long term and present same to the management committee for consideration and approval.</li>
                        <li>It shall execute an approved business plans.</li>
                        <li>It shall be present in the monthly executive meeting to give report through its chairman, on its activities.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.3.3 AUDIT COMMITTEE</h3>
                    <p>At the annual general meeting there shall be elected 3 members as audit committee. A quorum shall consist of 2 members. Members of this Committee should have background knowledge in Accounting, Islamic Jurisprudence and Islamic Finance and Economies.</p>
                </div>

                <div class="mb-6">
                    <h3>9.3.3a DUTIES OF AUDIT COMMITTEE</h3>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>The committee shall audit the affairs of the society which shall include its books.</li>
                        <li>It shall give a written report to the management committee of its findings following each audit report.</li>
                        <li>It shall make an Annual audit and submit same to the Annual General Meeting.</li>
                        <li>The committee shall meet at least once every quarter.</li>
                    </ol>
                </div>

                <div class="mb-6">
                    <h3>9.3.3b POWER OF THE AUDIT COMMITTEE</h3>
                    <p>The audit committee shall have the power to recommend the suspension of any officer, any or all members of the management committee or to call for a special meeting of the society to consider any violation of the rules and regulations according to the bye - laws of the society.</p>
                </div>
            </div>

            <!-- Section Ten -->
            <div id="section-ten" class="mb-12">
                <h2><span class="section-number">10.0</span> FUND AND INVESTMENT</h2>
                <div class="mb-6">
                    <h3>10.1 ACCOUNT SIGNATORIES, DEPOSITS IN BANKS OR OTHER INSTITUTIONS</h3>
                    <p>The funds of the Society shall be deposited with the approval of the General meeting in a Microfinance Bank, Commercial, or Jaiz Bank or any other bank approve for business.</p>
                </div>
                <div class="mb-6">
                    <h3>10.2 INVESTMENTS</h3>
                    <p>Such funds of the Society that are not required for recurrent use may be invested in manner entrenched in the bye - laws and allowed by the Sharia.</p>
                </div>
                <div class="mb-6">
                    <h3>10.3 OPERATIONS OF BANK ACCOUNTS</h3>
                    <p>The Society's fund in the bank account shall be withdrawn only when the withdrawal slip is signed by the chairman and either the treasurer or secretary, subject to approval of expenditure by the management committee.</p>
                </div>
            </div>

            <!-- Section Eleven -->
            <div id="section-eleven" class="mb-12">
                <h2><span class="section-number">11.0</span> ACCOUNTS AND DISPOSAL OF FUNDS</h2>
                <div class="mb-6">
                    <p><strong>a. Appropriation of surplus Profit:</strong> At the end of financial year, the annual net profit shall be appropriated as follows:</p>
                    <ol class="list-[lower-roman] space-y-2 ml-4">
                        <li>Ten percent (10%) to the reserve fund.</li>
                        <li>Not more than 15% honoraria, which shall be appropriated as 8% to Management Committee, 7% to members of Business / Investment Committee and appointing institutions.</li>
                        <li>Five percent (5%) training and community development.</li>
                        <li>The remainder (70%) shall be paid /credited to members as dividends in proportion to their savings as at 31st December each year.</li>
                        <li>Expelled members shall be entitled to profit already earned or not credited to his/her accounts if he participated in the transaction.</li>
                    </ol>
                </div>
                <div class="mb-6">
                    <p><strong>b. Liquidation:</strong> The Cooperative shall only be liquidated on the order of the Registrar under section 42 and 43 of the Co-operative law.</p>
                </div>
                <div class="mb-6">
                    <p><strong>b. Amendments:</strong> Any proposed amendment(s) to these Bye-Laws must be at least endorsed sanctioned by a 2/3 majority of members present at a General Meeting and submitted to the Registrar in accordance with the Regulations.</p>
                </div>
                <div class="mb-6">
                    <p><strong>c. Liability of a Past Member in the event of Death:</strong> The liability of a member in the event of death shall be waved as encouraged by Islam.</p>
                </div>
                <div class="mb-6">
                    <p><strong>d. Bank Accounts:</strong> With the exception of the circulating capital, the Management Committee shall immediately deposit the excess liquid funds of the Co-operative approve bank.</p>
                </div>
                <div class="mb-6">
                    <p><strong>e. Production of Cash Statement:</strong> The cash balance as shown in the Cash Book shall be produced at the General Meeting and also on request by the Registrar or his representative(s).</p>
                </div>
                <div class="mb-6">
                    <p><strong>f. Maintenance of Books and Registers:</strong></p>
                    <ol class="list-[lower-alpha] space-y-2 ml-4">
                        <li>Register of members showing names, address, postal address of admission into membership, date of termination of membership, reference in nominee(s) appointed.</li>
                        <li>Register showing member's attendance at meetings.</li>
                        <li>Cash Book showing the receipts and payments on each day business is run, general ledger, personal ledger containing account for each member, minute books' register, payment voucher, members' Pass Book, etc.</li>
                        <li>A file containing a copy of these Bye-Laws, Co-operative Laws and Regulations.</li>
                        <li>Registrar may prescribe such other record(s) as may be necessary for the operations of the corporative.</li>
                        <li>All Registers and Books of the Co-operative shall be opened to the inspection of all the members and any accredited Co-operative Officer, provided that no person other than an officer of the Cooperative, shall be allowed to see the personal account of any member without that member's written consent. The Chairman shall maintain in his/her custody the Co-operative's seal, which shall be of a pattern approved by the Registrar.</li>
                        <li>Such other Registers and Books which are found useful, from time to time may be maintained.</li>
                    </ol>
                </div>
            </div>

            <!-- Commencement Section -->
            <div id="commencement" class="mb-12 border-t-2 border-gray-100 pt-12">
                <h2 class="!mt-0">COMMENCEMENT OF THE BYE-LAW</h2>
                <p>The operation of this Bye-Law shall commence on the approval of the congress of <em>Ummah</em>.</p>
            </div>

            <!-- Committee Members -->
            <div id="committee-members" class="mb-12">
                <h3 class="text-xl font-bold text-army-green mb-6">Members of the Committee are:</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="py-3 px-4 font-bold text-gray-700">S/N</th>
                                <th class="py-3 px-4 font-bold text-gray-700">Name</th>
                                <th class="py-3 px-4 font-bold text-gray-700">Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr><td class="py-3 px-4">1.</td><td class="py-3 px-4">Mr. Shehu Sunusi Lalin</td><td class="py-3 px-4">Chairman</td></tr>
                            <tr><td class="py-3 px-4">2.</td><td class="py-3 px-4">Pharm. Ahmed Usman Tanze</td><td class="py-3 px-4">Vice Chairman</td></tr>
                            <tr><td class="py-3 px-4">3.</td><td class="py-3 px-4">Dr. Kabiru Atiku</td><td class="py-3 px-4">Secretary</td></tr>
                            <tr><td class="py-3 px-4">4.</td><td class="py-3 px-4">Dr. Liman Alhaji Mohammed (ACA)</td><td class="py-3 px-4">Financial Secretary</td></tr>
                            <tr><td class="py-3 px-4">5.</td><td class="py-3 px-4">Mr. Muhammad Musa Awadu</td><td class="py-3 px-4">Auditor</td></tr>
                            <tr><td class="py-3 px-4">6.</td><td class="py-3 px-4">Mrs. Hauwa Muhammad Abubakar</td><td class="py-3 px-4">Treasurer</td></tr>
                            <tr><td class="py-3 px-4">7.</td><td class="py-3 px-4">Mr. Abdullahi Tanko</td><td class="py-3 px-4">PRO</td></tr>
                            <tr><td class="py-3 px-4">8.</td><td class="py-3 px-4">Dr. Abubakar Tafida</td><td class="py-3 px-4">Ex-Officio</td></tr>
                            <tr><td class="py-3 px-4">9.</td><td class="py-3 px-4">Dr. Yusuf Bawa</td><td class="py-3 px-4">Ex-Officio</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-8 text-sm text-gray-500 italic">* This document has been officially approved and signed by the committee members listed above.</p>
            </div>

            <!-- Navigation Links -->
            <div class="mt-20 pt-10 border-t border-gray-100 flex justify-between items-center text-sm font-bold text-army-green">
                <a href="{{ route('home') }}#about" class="hover:text-gold transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to About
                </a>
                <a href="{{ route('join.step1') }}" class="hover:text-gold transition">
                    Become a Member <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

        </div>
    </main>

    <!-- Unified Footer -->
    <x-footer />

</body>
</html>
