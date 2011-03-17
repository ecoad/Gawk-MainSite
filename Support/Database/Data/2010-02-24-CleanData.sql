--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- Name: Address_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Address_Id_seq"', 1, true);


--
-- Name: Article_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Article_Id_seq"', 1, true);


--
-- Name: Binary_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Binary_Id_seq"', 1, true);


--
-- Name: BlogEntry_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"BlogEntry_Id_seq"', 19, true);


--
-- Name: Blog_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Blog_Id_seq"', 1, true);


--
-- Name: Comment_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Comment_Id_seq"', 1, true);


--
-- Name: Country_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Country_Id_seq"', 61, true);


--
-- Name: FeedbackNote_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"FeedbackNote_Id_seq"', 1, true);


--
-- Name: Feedback_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Feedback_Id_seq"', 1, true);


--
-- Name: MediaVaultItem_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"MediaVaultItem_Id_seq"', 24, true);


--
-- Name: MemberToAddress_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"MemberToAddress_Id_seq"', 299, true);


--
-- Name: MemberToSecurityGroup_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"MemberToSecurityGroup_Id_seq"', 682, true);


--
-- Name: Member_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Member_Id_seq"', 483, true);


--
-- Name: Note_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Note_Id_seq"', 1, true);


--
-- Name: Photo_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Photo_Id_seq"', 1, true);


--
-- Name: SecurityGroupToSecurityResource_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityGroupToSecurityResource_Id_seq"', 281, true);


--
-- Name: SecurityGroup_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityGroup_Id_seq"', 7, true);


--
-- Name: SecurityResource_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityResource_Id_seq"', 74, true);


--
-- Name: Setting_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Setting_Id_seq"', 1, true);


--
-- Name: TagToData_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TagToData_Id_seq"', 1, true);


--
-- Name: Tag_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Tag_Id_seq"', 1, true);


--
-- Name: TourDate_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TourDate_Id_seq"', 1, true);


--
-- Name: TourDetail_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TourDetail_Id_seq"', 1, true);


--
-- Name: Video_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Video_Id_seq"', 1, true);


--
-- Data for Name: Binary; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Binary" ("Id", "Filename", "Size", "MimeType", "Created", "Modified", "HashValue", "IsPublic") FROM stdin;
\.


--
-- Data for Name: Country; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Country" ("Id", "Name", "Currency", "Rate", "Code", "VatExempt", "RateUpdated", "Symbol", "ImageId", "FreeShippingThreshold", "Zone") FROM stdin;
46	Australia	AUD	2.1965113	AU	t	2009-03-11 16:15:20	$	\N	\N	4
47	Belgium	EUR	1.1123147	BE	f	2009-03-11 16:15:20	€	\N	\N	2
54	Canada	CAD	1.808107	CA	t	2009-03-11 16:15:21	$	\N	\N	3
55	France	EUR	1.1123147	FR	f	2009-03-11 16:15:21	€	\N	\N	2
48	Germany	EUR	1.1123147	GE	f	2009-03-11 16:15:21	€	\N	\N	2
49	Ireland	EUR	1.1123147	IRE	f	2009-03-11 16:15:21	€	\N	\N	2
43	Italy	EUR	1.1123147	ITA	f	2009-03-11 16:15:21	€	\N	\N	2
50	Japan	JPY	138.7049	JP	f	2009-03-11 16:15:21	¥	\N	\N	4
51	Netherlands	EUR	1.1123147	NL	f	2009-03-11 16:15:21	€	\N	\N	2
52	New Zealand	NZD	2.803767	NZ	t	2009-03-11 16:15:21	$	\N	\N	4
45	Norway	NOK	9.9278793	NO	t	2009-03-11 16:15:22	kr	\N	\N	2
61	Poland	EUR	1.1123147	PL	f	2009-03-11 16:15:22	€	\N	\N	2
44	Sweden	SEK	12.890082	SE	t	2009-03-11 16:15:22	kr	\N	\N	2
1	United Kingdom	GBP	1	GB	f	2009-03-11 16:15:22	£	\N	\N	1
53	USA	USD	1.4069678	US	t	2009-03-11 16:15:23	$	\N	\N	3
\.


--
-- Data for Name: Address; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Address" ("Id", "NamePrefix", "FirstName", "LastName", "CompanyOrHouseName", "AddressLine1", "AddressLine2", "Town", "Region", "Postcode", "TelephoneNumber", "EmailAddress", "CountryId", "Country", "Description", "DateCreated") FROM stdin;
\.


--
-- Data for Name: Article; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Article" ("Id", "Subject", "Summary", "Body", "DateCreated", "LiveDate", "ExpiryDate", "AuthorId", "Image1Id", "Attachment1Id", "Attachment2Id", "Attachment3Id", "ExtraDate1", "Tags", "Image2Id", "Image3Id", "Image4Id", "Attachment4Id", "Active") FROM stdin;
\.


--
-- Data for Name: Member; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") FROM stdin;
481	hannah.fitzpatrick@clock.co.uk	Hannah	7e7aad4b96c362fdd80bf8e4e026513e80407602	Hannah	Fitzpatrick	\N	9dd1b03a5989b0d4f4b13506b30c495ea1df1ef7	2008-12-10 14:51:08.177395	2008-12-10 14:51:08.177395	GMT	\N	\N	f	t	t	t	\N	\N	\N	\N	f	f	f	\N	\N	\N	\N	0	\N	\N	0	f	\N	\N	f	\N	0	\N	\N	t	\N	\N	t	\N	\N
13	syd@clock.co.uk	Syd	7e7aad4b96c362fdd80bf8e4e026513e80407602	Syd	Nadim	1973-09-05 00:00:00	6d7ad99e899762d5747e8da0dd9d88ffc8304b9d	2005-06-17 03:00:28.672618	2006-07-07 19:12:32.253619	GMT	\N	\N	f	f	t	f	\N	\N	\N	a5d964b56b11b20e1213f1f8c7ca1bd621f43f99	f	f	f	a7e6f0654ef5407fad4b1d7f7463ed8d7cbaefba	\N	\N	\N	0	\N	\N	6	f	\N	\N	f	\N	0	Rock!	\N	t	\N	5	\N	\N	\N
1	paul.serby@clock.co.uk	Serby	7e7aad4b96c362fdd80bf8e4e026513e80407602	Paul	Serby	1978-11-19 00:00:00	ce6f679e119d88211b4f7ce998c4c4b050a412fa	2004-07-29 00:33:21.625132	2008-12-18 12:17:07.678613	GMT	\N	\N	f	f	t	t	http://www.clock.co.uk/serby	--\r\nSerby	\N	7fccfe1d96b22831b8696684efec83394063edd2	f	f	f	7ba48d878f388529c5f0514f413953ddfc90a152	\N	\N	\N	4	\N	\N	705	f	\N	\N	f	\N	3.2857499	\N	\N	f	\N	5	f	\N	\N
457	andrew.devlin@clock.co.uk	devron	7e7aad4b96c362fdd80bf8e4e026513e80407602	Andrew	Devlin	1982-12-01 00:00:00	544a4fcf6c0757661b47dcee55d10434c7e51823	2007-04-12 08:48:02.887351	2008-10-15 08:28:23.871699	GMT	\N	\N	f	f	f	f	\N	\N	\N	4c3f8588a287277b5a710da7eed005e54fb350c5	f	f	f	7f319da17ad84201fc30bd9f60b0ea44b2741624	\N	\N	\N	0	\N	\N	9	f	\N	\N	f	\N	0	\N	\N	f	\N	\N	f	\N	\N
6	robert.arnold@clock.co.uk	ArnIIe	7e7aad4b96c362fdd80bf8e4e026513e80407602	Rob	Arnold	1980-10-22 00:00:00	474ac2ff023b32c23db6f73c68da5a60c61b4630	2005-06-15 15:50:27.779617	2009-07-30 17:04:01.341219	GMT	\N	\N	f	f	f	f	www.arniie.com	--<br /> Your the boss!	\N	f2dfc8186f06705e84a3352cdd728a6e369ee377	f	f	f	2c250b42177db9f9157cb2fda78cf00a9c6a9297	\N	\N	\N	9	\N	\N	489	f	\N	\N	f	\N	0.95999998	ROCK	\N	f	\N	6	f	\N	\N
482	heather.bickerstaff@clock.co.uk	hev	7e7aad4b96c362fdd80bf8e4e026513e80407602	Heather	Bickerstaff	1987-06-12 00:00:00	fabc944adc38f14b3b872e54c127699333c767f8	2009-02-23 11:06:49.055149	2009-08-04 16:06:06.864354	GMT	\N	\N	f	f	f	f	\N	\N	\N	\N	f	f	f	a53647ff6e8d67c46d99e59be08aecaf01bf8c01	\N	\N	\N	0	\N	\N	22	f	\N	\N	f	\N	0	\N	\N	f	\N	\N	f	\N	\N
483	luke.wilde@clock.co.uk	luke.wilde	7e7aad4b96c362fdd80bf8e4e026513e80407602	Luke	Wilde	1988-02-15 00:00:00	c06ec88445c9e8150522775992cf3c2e8c9f247b	2009-09-24 11:02:20.13397	2009-09-24 11:02:20.13397	GMT	\N	\N	f	f	f	f	\N	\N	\N	\N	f	f	f	\N	\N	\N	\N	0	\N	\N	0	f	\N	\N	f	\N	0	\N	\N	f	\N	\N	f	\N	\N
470	dom.udall@clock.co.uk	dmno	879d3c8cfcff7a7eb51a3474d1f356746beb8e8e	Dom	Udall	1987-01-14 00:00:00	b3ab97d2ef667bab30142c875fe877a35bfa157a	2008-02-26 18:31:20.782101	2009-12-01 13:38:01.132717	GMT	\N	\N	f	f	f	f	\N	\N	\N	9db54e8ac25a9758783e0c884ad783a00642d743	f	f	f		\N	\N	\N	0	\N	\N	51	f	\N	\N	f	\N	0	\N	Sonic the Hedgehog	f	Favourite super hero	\N	f	\N	\N
476	elliot.coad@clock.co.uk	elliot	7e7aad4b96c362fdd80bf8e4e026513e80407602	Elliot	Coad	\N	1	2008-03-17 12:29:17.744142	2010-01-29 11:38:56.460441	GMT	\N	\N	f	f	f	f	\N	\N	\N	42b83b6b76502d342a67483d4446ed93de3b9735	f	f	f		\N	84056d1931a4100841b790c91db556db5709f363	1264765149	0	\N	\N	12	f	\N	0	f	\N	0	\N	\N	f	\N	\N	\N	\N	\N
14	tom@clock.co.uk	Tom	7e7aad4b96c362fdd80bf8e4e026513e80407602	Tom	Smith	\N	83b94d73879d4a8ac238c88cdcfce8e5d9914257	2006-02-27 14:59:45.581028	2010-02-23 19:05:13.918537	GMT	\N	\N	f	f	t	t	\N	\N	\N	7338efaff65d62d493440f6f56fcdc6a235df5dc	f	t	f	a559badd43c56ae0f1d537752913f8cf3d546a44	\N	\N	\N	2	\N	\N	68	f	\N	\N	f	\N	0	\N	\N	f	\N	\N	f	\N	\N
480	andy@clock.co.uk	andy	7e7aad4b96c362fdd80bf8e4e026513e80407602	Andy	Shanley	1982-04-26 00:00:00	540c7ba214867058499cf535eb36987ffead02d4	2008-09-08 15:21:16.448959	2009-11-26 16:15:12.312586	GMT	\N	\N	f	f	f	f	\N	\N	\N	cfd49bf8276a771737233b47bc1e59d155b269a1	f	f	f	6e73231f537abd7d478f0140010bd8fe197f2153	\N	\N	\N	0	\N	\N	105	f	\N	\N	f	\N	0	\N	\N	f	\N	\N	f	\N	\N
\.


--
-- Data for Name: Blog; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Blog" ("Id", "Title", "Description", "AuthorId", "Entries", "LastEntry", "ImageId", "DateCreated") FROM stdin;
\.


--
-- Data for Name: BlogEntry; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "BlogEntry" ("Id", "BlogId", "Subject", "Body", "DateCreated", "ImageId", "Image2Id", "Image3Id", "Image4Id", "Image5Id", "Image6Id", "AuthorId", "PutLive") FROM stdin;
\.


--
-- Data for Name: Comment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Comment" ("Id", "RelationId", "RelationType", "AuthorId", "DateCreated", "Body", "LastModified", "IpAddress", "Anonymous", "Approved") FROM stdin;
\.


--
-- Data for Name: Feedback; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Feedback" ("Id", "Reference", "Subject", "Body", "IpAddress", "DateCreated", "Status", "FullName", "EmailAddress", "Parent") FROM stdin;
\.


--
-- Data for Name: FeedbackNote; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "FeedbackNote" ("Id", "FeedbackId", "DateCreated", "Body", "MemberId", "Status") FROM stdin;
\.


--
-- Data for Name: MemberToAddress; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "MemberToAddress" ("Id", "MemberId", "AddressId") FROM stdin;
\.


--
-- Data for Name: SecurityGroup; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "SecurityGroup" ("Id", "Name", "Description", "DateCreated") FROM stdin;
1	Basic	Basic security access to the site. All member have this level of security.	\N
3	Admin	Admin security access allows give full access to all parts of the site.	\N
\.


--
-- Data for Name: MemberToSecurityGroup; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") FROM stdin;
25	13	1
10	6	1
11	6	3
38	13	3
582	1	3
583	1	1
611	457	3
624	476	1
625	476	3
633	470	1
662	14	1
665	14	3
666	481	1
667	481	3
671	480	3
679	482	3
680	482	1
681	483	3
682	483	1
\.


--
-- Data for Name: Note; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Note" ("Id", "MemberId", "DateCreated", "Description", "CapturedId", "IpAddress", "Type", "Status", "FolderLocation") FROM stdin;
\.


--
-- Data for Name: Photo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Photo" ("Id", "ImageId", "Caption", "DateCreated", "AuthorId", "ThumbnailId", "Tags") FROM stdin;
\.


--
-- Data for Name: SecurityResource; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "SecurityResource" ("Id", "Name", "Description") FROM stdin;
26	Cache Admin	Cache Admin
34	Feedback Admin	Feedback Admin
47	Blog Admin	Blog Admin
48	Blog	Blog
57	Client Admin	Client Admin
59	Store	Store
60	Store Admin	Store Admin
19	Security Group Admin	Security Group Admin
25	Security Resource Admin	Security Resource Admin
13	News Admin	News Admin
4	News	News
23	Member Update	Member Update
12	Member Admin	Member Admin
3	Member	Member
11	Forum Admin	Forum Admin
2	Forum	Forum
24	Admin	General admin group to gain access to the admin home page
1	Basic	General admin group to gain access to the Web site home page
62	Client	Client
63	Feedback	Feedback
65	Advanced Admin	Advanced Admin
64	Gallery	Gallery
52	Gallery Admin	Gallery Admin
66	Tag Admin	Tag Admin
61	Tour	Tour
58	Tour Admin	Tour Admin
68	Donation	Donation
67	Donation Admin	Donation Admin
71	Sponsorship Admin	Sponsorship Admin
72	Sponsorship	Sponsorship
73	Country Admin	Country Admin
70	Comments	Comments
69	Comments Admin	Comments Admin
74	Event Admin	Event Admin
\.


--
-- Data for Name: SecurityGroupToSecurityResource; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") FROM stdin;
31	1	Basic
33	1	News
34	1	Member
35	1	Forum
40	1	Member Update
44	3	Admin
111	1	Blog
149	3	Blog
150	3	Blog Admin
151	3	Cache Admin
157	3	Feedback Admin
158	3	Forum
159	3	Forum Admin
163	3	Member
164	3	Member Admin
165	3	Member Update
167	3	News
168	3	News Admin
186	3	Security Group Admin
187	3	Security Resource Admin
255	3	Basic
256	3	Client Admin
258	3	Store
259	3	Store Admin
260	1	Store
261	3	Client
262	3	Feedback
265	1	Client
266	1	Feedback
269	3	Advanced Admin
263	3	Gallery
267	1	Gallery
173	3	Gallery Admin
270	3	Tag Admin
264	3	Tour
268	1	Tour
257	3	Tour Admin
271	1	Donation
272	3	Donation
273	3	Donation Admin
277	3	Sponsorship
278	3	Sponsorship Admin
279	1	Sponsorship
280	3	Country Admin
274	3	Comments
276	1	Comments
275	3	Comments Admin
281	3	Event Admin
\.


--
-- Data for Name: Setting; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Setting" ("Id", "MemberId", "Name", "Value") FROM stdin;
\.


--
-- Data for Name: Tag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Tag" ("Id", "Tag", "BrokenTag", "TextIndex") FROM stdin;
\.


--
-- Data for Name: TagToData; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TagToData" ("Id", "Tag", "DataId", "Type") FROM stdin;
\.


--
-- Data for Name: TourDetail; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TourDetail" ("Id", "ImageId", "ThumbnailId", "Title", "DateCreated") FROM stdin;
\.


--
-- Data for Name: TourDate; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "TourDate" ("Id", "Venue", "Location", "VenueWebsite", "BookingWebsite", "TelephoneNumber", "LiveDate", "TourDate", "DateCreated", "AuthorId", "TourDetailId") FROM stdin;
\.


--
-- Data for Name: Video; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Video" ("Id", "VideoId", "Caption", "AuthorId", "Tags", "DateCreated", "ThumbnailId", "VideoSource") FROM stdin;
\.


--
-- Data for Name: pg_ts_cfg; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pg_ts_cfg (ts_name, prs_name, locale) FROM stdin;
default_russian	default	ru_RU.KOI8-R
default	default	\N
simple	default	en_GB.UTF-8
\.


--
-- Data for Name: pg_ts_cfgmap; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pg_ts_cfgmap (ts_name, tok_alias, dict_name) FROM stdin;
default	lword	{en_stem}
default	nlword	{simple}
default	word	{simple}
default	email	{simple}
default	url	{simple}
default	host	{simple}
default	sfloat	{simple}
default	version	{simple}
default	part_hword	{simple}
default	nlpart_hword	{simple}
default	lpart_hword	{en_stem}
default	hword	{simple}
default	lhword	{en_stem}
default	nlhword	{simple}
default	uri	{simple}
default	file	{simple}
default	float	{simple}
default	int	{simple}
default	uint	{simple}
default_russian	lword	{en_stem}
default_russian	nlword	{ru_stem}
default_russian	word	{ru_stem}
default_russian	email	{simple}
default_russian	url	{simple}
default_russian	host	{simple}
default_russian	sfloat	{simple}
default_russian	version	{simple}
default_russian	part_hword	{simple}
default_russian	nlpart_hword	{ru_stem}
default_russian	lpart_hword	{en_stem}
default_russian	hword	{ru_stem}
default_russian	lhword	{en_stem}
default_russian	nlhword	{ru_stem}
default_russian	uri	{simple}
default_russian	file	{simple}
default_russian	float	{simple}
default_russian	int	{simple}
default_russian	uint	{simple}
simple	lword	{simple}
simple	nlword	{simple}
simple	word	{simple}
simple	email	{simple}
simple	url	{simple}
simple	host	{simple}
simple	sfloat	{simple}
simple	version	{simple}
simple	part_hword	{simple}
simple	nlpart_hword	{simple}
simple	lpart_hword	{simple}
simple	hword	{simple}
simple	lhword	{simple}
simple	nlhword	{simple}
simple	uri	{simple}
simple	file	{simple}
simple	float	{simple}
simple	int	{simple}
simple	uint	{simple}
default_english	lhword	{en_ispell,en_stem}
default_english	lpart_hword	{en_ispell,en_stem}
default_english	lword	{en_ispell,en_stem}
default_english	url	{simple}
default_english	host	{simple}
default_english	sfloat	{simple}
default_english	uri	{simple}
default_english	int	{simple}
default_english	float	{simple}
default_english	email	{simple}
default_english	word	{simple}
default_english	hword	{simple}
default_english	nlword	{simple}
default_english	nlpart_hword	{simple}
default_english	part_hword	{simple}
default_english	nlhword	{simple}
default_english	file	{simple}
default_english	uint	{simple}
default_english	version	{simple}
\.


--
-- Data for Name: pg_ts_dict; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pg_ts_dict (dict_name, dict_initoption, dict_comment, dict_init, dict_lexize) FROM stdin;
simple	\N	Simple example of dictionary.	dex_init(internal)	dex_lexize(internal,internal,integer)
en_stem	/usr/share/postgresql/contrib/english.stop	English Stemmer. Snowball.	snb_en_init(internal)	snb_lexize(internal,internal,integer)
ru_stem	/usr/share/postgresql/contrib/russian.stop	Russian Stemmer. Snowball.	snb_ru_init(internal)	snb_lexize(internal,internal,integer)
ispell_template	\N	ISpell interface. Must have .dict and .aff files	spell_init(internal)	spell_lexize(internal,internal,integer)
synonym	\N	Example of synonym dictionary	syn_init(internal)	syn_lexize(internal,internal,integer)
en_ispell	DictFile="/usr/local/lib/english.dict",AffFile="/usr/local/lib/english.aff",StopFile="/usr/share/postgresql/contrib/english.stop"	\N	spell_init(internal)	spell_lexize(internal,internal,integer)
\.


--
-- Data for Name: pg_ts_parser; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pg_ts_parser (prs_name, prs_comment, prs_start, prs_nexttoken, prs_end, prs_headline, prs_lextype) FROM stdin;
default	Parser from OpenFTS v0.34	prsd_start(internal,integer)	prsd_getlexeme(internal,internal,internal)	prsd_end(internal)	prsd_headline(internal,internal,internal)	prsd_lextype(internal)
\.


--
-- PostgreSQL database dump complete
--

