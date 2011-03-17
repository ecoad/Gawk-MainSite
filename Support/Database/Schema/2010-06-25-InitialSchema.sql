--
-- PostgreSQL database dump
--

-- Started on 2010-07-28 13:24:11 BST

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1504 (class 1259 OID 109289)
-- Dependencies: 1792 1793 1794 3
-- Name: Binary; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Binary" (
    "Id" integer NOT NULL,
    "Filename" text NOT NULL,
    "Size" integer,
    "MimeType" text NOT NULL,
    "Created" timestamp without time zone DEFAULT now() NOT NULL,
    "Modified" timestamp without time zone DEFAULT now() NOT NULL,
    "HashValue" text NOT NULL,
    "IsPublic" boolean DEFAULT true
);


ALTER TABLE public."Binary" OWNER TO postgres;

--
-- TOC entry 1523 (class 1259 OID 109575)
-- Dependencies: 3
-- Name: BinaryCrop; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "BinaryCrop" (
    "Id" integer NOT NULL,
    "CropX" integer,
    "CropY" integer,
    "CropH" integer,
    "CropW" integer,
    "CropX2" integer,
    "CropY2" integer
);


ALTER TABLE public."BinaryCrop" OWNER TO postgres;

--
-- TOC entry 1522 (class 1259 OID 109573)
-- Dependencies: 1523 3
-- Name: BinaryCrop_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "BinaryCrop_Id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."BinaryCrop_Id_seq" OWNER TO postgres;

--
-- TOC entry 1896 (class 0 OID 0)
-- Dependencies: 1522
-- Name: BinaryCrop_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "BinaryCrop_Id_seq" OWNED BY "BinaryCrop"."Id";


--
-- TOC entry 1897 (class 0 OID 0)
-- Dependencies: 1522
-- Name: BinaryCrop_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"BinaryCrop_Id_seq"', 1, false);


--
-- TOC entry 1505 (class 1259 OID 109298)
-- Dependencies: 1504 3
-- Name: Binary_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Binary_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."Binary_Id_seq" OWNER TO postgres;

--
-- TOC entry 1899 (class 0 OID 0)
-- Dependencies: 1505
-- Name: Binary_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Binary_Id_seq" OWNED BY "Binary"."Id";


--
-- TOC entry 1900 (class 0 OID 0)
-- Dependencies: 1505
-- Name: Binary_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Binary_Id_seq"', 1, true);



--
-- TOC entry 1506 (class 1259 OID 109348)
-- Dependencies: 1797 1798 1799 1800 1801 1802 1803 1804 1805 1806 1807 1808 1809 1810 1811 1812 1813 3
-- Name: Member; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Member" (
    "Id" integer NOT NULL,
    "EmailAddress" text NOT NULL,
    "Alias" text NOT NULL,
    "Password" text NOT NULL,
    "FirstName" text,
    "LastName" text,
    "DateOfBirth" timestamp without time zone,
    "ConfirmationId" text NOT NULL,
    "DateCreated" timestamp without time zone DEFAULT now() NOT NULL,
    "LastVisit" timestamp without time zone DEFAULT now() NOT NULL,
    "TimeZone" text DEFAULT 1 NOT NULL,
    "MobileNumber" text,
    "MobileOperator" text,
    "MobileConfirmed" boolean DEFAULT false NOT NULL,
    "ReceiveEmailUpdates" boolean DEFAULT false NOT NULL,
    "ShowOnlineStatus" boolean DEFAULT false NOT NULL,
    "ShowEmailAddress" boolean DEFAULT false NOT NULL,
    "WebSite" text,
    "Signature" text,
    "ImageId" integer,
    "AutoLogonId" text,
    "Confirmed" boolean DEFAULT false,
    "ShowProfile" boolean DEFAULT false,
    "Blocked" boolean DEFAULT false,
    "AuthId" text,
    "NamePrefix" text,
    "PasswordRequestId" text,
    "PasswordRequestTime" text,
    "Posts" integer DEFAULT 0 NOT NULL,
    "From" text,
    "HeardAboutUs" text,
    "Visits" integer DEFAULT 0,
    "ReceiveSmsUpdates" boolean DEFAULT false,
    "FromCountry" text,
    "Gender" integer DEFAULT 0,
    "Question1" boolean DEFAULT false,
    "Comments" text,
    "PrepaidCredit" real DEFAULT 0,
    "AudioPreferences" text,
    "SecurityAnswer" text,
    "ReceiveRelatedPromotions" boolean DEFAULT false,
    "SecurityQuestion" text,
    "InternetConnection" integer,
    "TermsAgreed" boolean,
    "Postcode" text,
    "Title" text
);


ALTER TABLE public."Member" OWNER TO postgres;

--
-- TOC entry 1904 (class 0 OID 0)
-- Dependencies: 1506
-- Name: COLUMN "Member"."Question1"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Member"."Question1" IS 'Simple yes/no question for register page';


--
-- TOC entry 1905 (class 0 OID 0)
-- Dependencies: 1506
-- Name: COLUMN "Member"."Comments"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Member"."Comments" IS 'Comments which the user makes when they register';


--
-- TOC entry 1520 (class 1259 OID 109545)
-- Dependencies: 3
-- Name: MemberToSecurityGroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "MemberToSecurityGroup" (
    "Id" integer NOT NULL,
    "MemberId" integer NOT NULL,
    "SecurityGroupId" integer NOT NULL
);


ALTER TABLE public."MemberToSecurityGroup" OWNER TO postgres;

--
-- TOC entry 1521 (class 1259 OID 109548)
-- Dependencies: 3 1520
-- Name: MemberToSecurityGroup_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "MemberToSecurityGroup_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."MemberToSecurityGroup_Id_seq" OWNER TO postgres;

--
-- TOC entry 1908 (class 0 OID 0)
-- Dependencies: 1521
-- Name: MemberToSecurityGroup_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "MemberToSecurityGroup_Id_seq" OWNED BY "MemberToSecurityGroup"."Id";


--
-- TOC entry 1909 (class 0 OID 0)
-- Dependencies: 1521
-- Name: MemberToSecurityGroup_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"MemberToSecurityGroup_Id_seq"', 682, true);


--
-- TOC entry 1507 (class 1259 OID 109371)
-- Dependencies: 1506 3
-- Name: Member_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Member_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."Member_Id_seq" OWNER TO postgres;

--
-- TOC entry 1911 (class 0 OID 0)
-- Dependencies: 1507
-- Name: Member_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Member_Id_seq" OWNED BY "Member"."Id";


--
-- TOC entry 1912 (class 0 OID 0)
-- Dependencies: 1507
-- Name: Member_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Member_Id_seq"', 483, true);


--
-- TOC entry 1508 (class 1259 OID 109373)
-- Dependencies: 1815 3
-- Name: SecurityGroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "SecurityGroup" (
    "Id" integer NOT NULL,
    "Name" text NOT NULL,
    "Description" text,
    "DateCreated" timestamp without time zone DEFAULT now()
);


ALTER TABLE public."SecurityGroup" OWNER TO postgres;

--
-- TOC entry 1509 (class 1259 OID 109380)
-- Dependencies: 3
-- Name: SecurityGroupToSecurityResource; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "SecurityGroupToSecurityResource" (
    "Id" integer NOT NULL,
    "SecurityGroupId" integer NOT NULL,
    "SecurityResourceName" text NOT NULL
);


ALTER TABLE public."SecurityGroupToSecurityResource" OWNER TO postgres;

--
-- TOC entry 1510 (class 1259 OID 109386)
-- Dependencies: 3 1509
-- Name: SecurityGroupToSecurityResource_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "SecurityGroupToSecurityResource_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."SecurityGroupToSecurityResource_Id_seq" OWNER TO postgres;

--
-- TOC entry 1916 (class 0 OID 0)
-- Dependencies: 1510
-- Name: SecurityGroupToSecurityResource_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "SecurityGroupToSecurityResource_Id_seq" OWNED BY "SecurityGroupToSecurityResource"."Id";


--
-- TOC entry 1917 (class 0 OID 0)
-- Dependencies: 1510
-- Name: SecurityGroupToSecurityResource_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityGroupToSecurityResource_Id_seq"', 281, true);


--
-- TOC entry 1511 (class 1259 OID 109388)
-- Dependencies: 3 1508
-- Name: SecurityGroup_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "SecurityGroup_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."SecurityGroup_Id_seq" OWNER TO postgres;

--
-- TOC entry 1919 (class 0 OID 0)
-- Dependencies: 1511
-- Name: SecurityGroup_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "SecurityGroup_Id_seq" OWNED BY "SecurityGroup"."Id";


--
-- TOC entry 1920 (class 0 OID 0)
-- Dependencies: 1511
-- Name: SecurityGroup_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityGroup_Id_seq"', 7, true);


--
-- TOC entry 1512 (class 1259 OID 109390)
-- Dependencies: 3
-- Name: SecurityResource; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "SecurityResource" (
    "Id" integer NOT NULL,
    "Name" text NOT NULL,
    "Description" text
);


ALTER TABLE public."SecurityResource" OWNER TO postgres;

--
-- TOC entry 1513 (class 1259 OID 109396)
-- Dependencies: 3 1512
-- Name: SecurityResource_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "SecurityResource_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."SecurityResource_Id_seq" OWNER TO postgres;

--
-- TOC entry 1923 (class 0 OID 0)
-- Dependencies: 1513
-- Name: SecurityResource_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "SecurityResource_Id_seq" OWNED BY "SecurityResource"."Id";


--
-- TOC entry 1924 (class 0 OID 0)
-- Dependencies: 1513
-- Name: SecurityResource_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"SecurityResource_Id_seq"', 75, true);


--
-- TOC entry 1514 (class 1259 OID 109398)
-- Dependencies: 3
-- Name: Setting; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Setting" (
    "Id" integer NOT NULL,
    "MemberId" integer NOT NULL,
    "Name" text NOT NULL,
    "Value" text NOT NULL
);


ALTER TABLE public."Setting" OWNER TO postgres;

--
-- TOC entry 1515 (class 1259 OID 109404)
-- Dependencies: 1514 3
-- Name: Setting_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Setting_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."Setting_Id_seq" OWNER TO postgres;

--
-- TOC entry 1927 (class 0 OID 0)
-- Dependencies: 1515
-- Name: Setting_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Setting_Id_seq" OWNED BY "Setting"."Id";


--
-- TOC entry 1928 (class 0 OID 0)
-- Dependencies: 1515
-- Name: Setting_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Setting_Id_seq"', 1, true);


--
-- TOC entry 1516 (class 1259 OID 109406)
-- Dependencies: 3
-- Name: Tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "Tag" (
    "Id" integer NOT NULL,
    "Tag" text NOT NULL,
    "BrokenTag" text NOT NULL,
    "TextIndex" tsvector
);


ALTER TABLE public."Tag" OWNER TO postgres;

--
-- TOC entry 1517 (class 1259 OID 109412)
-- Dependencies: 3
-- Name: TagToData; Type: TABLE; Schema: public; Owner: postgres; Tablespace:
--

CREATE TABLE "TagToData" (
    "Id" integer NOT NULL,
    "Tag" text NOT NULL,
    "DataId" integer NOT NULL,
    "Type" text NOT NULL
);


ALTER TABLE public."TagToData" OWNER TO postgres;

--
-- TOC entry 1518 (class 1259 OID 109418)
-- Dependencies: 3 1517
-- Name: TagToData_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "TagToData_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."TagToData_Id_seq" OWNER TO postgres;

--
-- TOC entry 1932 (class 0 OID 0)
-- Dependencies: 1518
-- Name: TagToData_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "TagToData_Id_seq" OWNED BY "TagToData"."Id";


--
-- TOC entry 1933 (class 0 OID 0)
-- Dependencies: 1518
-- Name: TagToData_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"TagToData_Id_seq"', 1, true);


--
-- TOC entry 1519 (class 1259 OID 109420)
-- Dependencies: 3 1516
-- Name: Tag_Id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Tag_Id_seq"
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."Tag_Id_seq" OWNER TO postgres;

--
-- TOC entry 1935 (class 0 OID 0)
-- Dependencies: 1519
-- Name: Tag_Id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Tag_Id_seq" OWNED BY "Tag"."Id";


--
-- TOC entry 1936 (class 0 OID 0)
-- Dependencies: 1519
-- Name: Tag_Id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Tag_Id_seq"', 1, true);


--
-- TOC entry 1795 (class 2604 OID 109423)
-- Dependencies: 1505 1504
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "Binary" ALTER COLUMN "Id" SET DEFAULT nextval('"Binary_Id_seq"'::regclass);


--
-- TOC entry 1822 (class 2604 OID 109578)
-- Dependencies: 1522 1523 1523
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "BinaryCrop" ALTER COLUMN "Id" SET DEFAULT nextval('"BinaryCrop_Id_seq"'::regclass);

--
-- TOC entry 1796 (class 2604 OID 109429)
-- Dependencies: 1507 1506
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "Member" ALTER COLUMN "Id" SET DEFAULT nextval('"Member_Id_seq"'::regclass);


--
-- TOC entry 1821 (class 2604 OID 109550)
-- Dependencies: 1521 1520
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "MemberToSecurityGroup" ALTER COLUMN "Id" SET DEFAULT nextval('"MemberToSecurityGroup_Id_seq"'::regclass);


--
-- TOC entry 1814 (class 2604 OID 109430)
-- Dependencies: 1511 1508
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "SecurityGroup" ALTER COLUMN "Id" SET DEFAULT nextval('"SecurityGroup_Id_seq"'::regclass);


--
-- TOC entry 1816 (class 2604 OID 109431)
-- Dependencies: 1510 1509
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "SecurityGroupToSecurityResource" ALTER COLUMN "Id" SET DEFAULT nextval('"SecurityGroupToSecurityResource_Id_seq"'::regclass);


--
-- TOC entry 1817 (class 2604 OID 109432)
-- Dependencies: 1513 1512
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "SecurityResource" ALTER COLUMN "Id" SET DEFAULT nextval('"SecurityResource_Id_seq"'::regclass);


--
-- TOC entry 1818 (class 2604 OID 109433)
-- Dependencies: 1515 1514
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "Setting" ALTER COLUMN "Id" SET DEFAULT nextval('"Setting_Id_seq"'::regclass);


--
-- TOC entry 1819 (class 2604 OID 109434)
-- Dependencies: 1519 1516
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "Tag" ALTER COLUMN "Id" SET DEFAULT nextval('"Tag_Id_seq"'::regclass);


--
-- TOC entry 1820 (class 2604 OID 109435)
-- Dependencies: 1518 1517
-- Name: Id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE "TagToData" ALTER COLUMN "Id" SET DEFAULT nextval('"TagToData_Id_seq"'::regclass);


--
-- TOC entry 1879 (class 0 OID 109289)
-- Dependencies: 1504
-- Data for Name: Binary; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1888 (class 0 OID 109575)
-- Dependencies: 1523
-- Data for Name: BinaryCrop; Type: TABLE DATA; Schema: public; Owner: postgres
--




--
-- TOC entry 1880 (class 0 OID 109348)
-- Dependencies: 1506
-- Data for Name: Member; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (458, 'lee.knight@clock.co.uk', 'Lee', '0fb6cef4b00c1ddc94981d67096eae56347171ba', 'Lee', 'Knight', '1973-05-21 00:00:00', '5ace9ac1e348109c4d7390e5dafa931021b83c4c', '2007-04-12 17:07:34.637412', '2007-04-20 17:16:40.541963', 'GMT', NULL, NULL, false, true, true, true, NULL, NULL, NULL, NULL, true, true, false, '', 'Mr', NULL, NULL, 0, NULL, NULL, 5, true, NULL, NULL, false, NULL, 0, NULL, NULL, true, NULL, 13, true, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (481, 'hannah.fitzpatrick@clock.co.uk', 'Hannah', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Hannah', 'Fitzpatrick', NULL, '9dd1b03a5989b0d4f4b13506b30c495ea1df1ef7', '2008-12-10 14:51:08.177395', '2008-12-10 14:51:08.177395', 'GMT', NULL, NULL, false, true, true, true, NULL, NULL, NULL, NULL, false, false, false, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, false, NULL, NULL, false, NULL, 0, NULL, NULL, true, NULL, NULL, true, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (13, 'syd@clock.co.uk', 'Syd', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Syd', 'Nadim', '1973-09-05 00:00:00', '6d7ad99e899762d5747e8da0dd9d88ffc8304b9d', '2005-06-17 03:00:28.672618', '2006-07-07 19:12:32.253619', 'GMT', NULL, NULL, false, false, true, false, NULL, NULL, NULL, 'a5d964b56b11b20e1213f1f8c7ca1bd621f43f99', false, false, false, 'a7e6f0654ef5407fad4b1d7f7463ed8d7cbaefba', NULL, NULL, NULL, 0, NULL, NULL, 6, false, NULL, NULL, false, NULL, 0, 'Rock!', NULL, true, NULL, 5, NULL, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (1, 'paul.serby@clock.co.uk', 'Serby', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Paul', 'Serby', '1978-11-19 00:00:00', 'ce6f679e119d88211b4f7ce998c4c4b050a412fa', '2004-07-29 00:33:21.625132', '2008-12-18 12:17:07.678613', 'GMT', NULL, NULL, false, false, true, true, 'http://www.clock.co.uk/serby', '--
Serby', NULL, '7fccfe1d96b22831b8696684efec83394063edd2', false, false, false, '7ba48d878f388529c5f0514f413953ddfc90a152', NULL, NULL, NULL, 4, NULL, NULL, 705, false, NULL, NULL, false, NULL, 3.2857499, NULL, NULL, false, NULL, 5, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (457, 'andrew.devlin@clock.co.uk', 'devron', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Andrew', 'Devlin', '1982-12-01 00:00:00', '544a4fcf6c0757661b47dcee55d10434c7e51823', '2007-04-12 08:48:02.887351', '2008-10-15 08:28:23.871699', 'GMT', NULL, NULL, false, false, false, false, NULL, NULL, NULL, '4c3f8588a287277b5a710da7eed005e54fb350c5', false, false, false, '7f319da17ad84201fc30bd9f60b0ea44b2741624', NULL, NULL, NULL, 0, NULL, NULL, 9, false, NULL, NULL, false, NULL, 0, NULL, NULL, false, NULL, NULL, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (6, 'robert.arnold@clock.co.uk', 'ArnIIe', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Rob', 'Arnold', '1980-10-22 00:00:00', '474ac2ff023b32c23db6f73c68da5a60c61b4630', '2005-06-15 15:50:27.779617', '2009-07-30 17:04:01.341219', 'GMT', NULL, NULL, false, false, false, false, 'www.arniie.com', '--<br /> Your the boss!', NULL, 'f2dfc8186f06705e84a3352cdd728a6e369ee377', false, false, false, '2c250b42177db9f9157cb2fda78cf00a9c6a9297', NULL, NULL, NULL, 9, NULL, NULL, 489, false, NULL, NULL, false, NULL, 0.95999998, 'ROCK', NULL, false, NULL, 6, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (470, 'dom.udall@clock.co.uk', 'dmno', '879d3c8cfcff7a7eb51a3474d1f356746beb8e8e', 'Dom', 'Udall', '1987-01-14 00:00:00', 'b3ab97d2ef667bab30142c875fe877a35bfa157a', '2008-02-26 18:31:20.782101', '2009-09-17 15:00:43.680359', 'GMT', NULL, NULL, false, false, false, false, NULL, NULL, NULL, '9db54e8ac25a9758783e0c884ad783a00642d743', false, false, false, '3b061bc960238cec6008d603ce154d719b3e5707', NULL, NULL, NULL, 0, NULL, NULL, 50, false, NULL, NULL, false, NULL, 0, NULL, 'Sonic the Hedgehog', false, 'Favourite super hero', NULL, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (476, 'elliot.coad@clock.co.uk', 'elliot', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Elliot', 'Coad', NULL, '1', '2008-03-17 12:29:17.744142', '2009-09-24 11:01:00.274193', 'GMT', NULL, NULL, false, false, false, false, NULL, NULL, NULL, '2618a34a312f72d9be861ad88d978db07a7c7e99', false, false, false, '7f53bf934a666f877992390075aec052d54fc324', NULL, NULL, NULL, 0, NULL, NULL, 9, false, NULL, 0, false, NULL, 0, NULL, NULL, false, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (483, 'luke.wilde@clock.co.uk', 'luke.wilde', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Luke', 'Wilde', '1988-02-15 00:00:00', 'c06ec88445c9e8150522775992cf3c2e8c9f247b', '2009-09-24 11:02:20.13397', '2009-09-24 11:02:20.13397', 'GMT', NULL, NULL, false, false, false, false, NULL, NULL, NULL, NULL, false, false, false, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, false, NULL, NULL, false, NULL, 0, NULL, NULL, false, NULL, NULL, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (14, 'tom@clock.co.uk', 'Tom', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Tom', 'Smith', NULL, '83b94d73879d4a8ac238c88cdcfce8e5d9914257', '2006-02-27 14:59:45.581028', '2009-11-02 14:00:30.730427', 'GMT', NULL, NULL, false, false, true, true, NULL, NULL, NULL, '682b9b0b3842cc6eab56a3550934efdacc3fa523', false, true, false, '0a04246bc39b680b32a16a1952d5c446bb8fa109', NULL, NULL, NULL, 2, NULL, NULL, 63, false, NULL, NULL, false, NULL, 0, NULL, NULL, false, NULL, NULL, false, NULL, NULL);
INSERT INTO "Member" ("Id", "EmailAddress", "Alias", "Password", "FirstName", "LastName", "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "TimeZone", "MobileNumber", "MobileOperator", "MobileConfirmed", "ReceiveEmailUpdates", "ShowOnlineStatus", "ShowEmailAddress", "WebSite", "Signature", "ImageId", "AutoLogonId", "Confirmed", "ShowProfile", "Blocked", "AuthId", "NamePrefix", "PasswordRequestId", "PasswordRequestTime", "Posts", "From", "HeardAboutUs", "Visits", "ReceiveSmsUpdates", "FromCountry", "Gender", "Question1", "Comments", "PrepaidCredit", "AudioPreferences", "SecurityAnswer", "ReceiveRelatedPromotions", "SecurityQuestion", "InternetConnection", "TermsAgreed", "Postcode", "Title") VALUES (486, 'ben.hutton@clock.co.uk', 'ben.hutton', '7e7aad4b96c362fdd80bf8e4e026513e80407602', 'Ben', 'Hutton', NULL, '1', '2010-07-28 12:16:20.376065', '2010-07-28 12:16:20.376065', '1', NULL, NULL, false, false, false, false, NULL, NULL, NULL, NULL, false, false, false, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, false, NULL, 0, false, NULL, 0, NULL, NULL, false, NULL, NULL, NULL, NULL, NULL);


--
-- TOC entry 1887 (class 0 OID 109545)
-- Dependencies: 1520
-- Data for Name: MemberToSecurityGroup; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (509, 458, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (25, 13, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (10, 6, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (11, 6, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (511, 458, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (38, 13, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (582, 1, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (583, 1, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (611, 457, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (624, 476, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (625, 476, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (633, 470, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (662, 14, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (665, 14, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (666, 481, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (667, 481, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (681, 483, 3);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (682, 483, 1);
INSERT INTO "MemberToSecurityGroup" ("Id", "MemberId", "SecurityGroupId") VALUES (683, 486, 31);


--
-- TOC entry 1881 (class 0 OID 109373)
-- Dependencies: 1508
-- Data for Name: SecurityGroup; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "SecurityGroup" ("Id", "Name", "Description", "DateCreated") VALUES (1, 'Basic', 'Basic security access to the site. All member have this level of security.', NULL);
INSERT INTO "SecurityGroup" ("Id", "Name", "Description", "DateCreated") VALUES (3, 'Admin', 'Admin security access allows give full access to all parts of the site.', NULL);
INSERT INTO "SecurityGroup" ("Id", "Name", "Description", "DateCreated") VALUES (31, 'Author', 'Author has acces to some admin areas of the site which enable them to make posts on a blog blog entry', '2010-07-07 10:25:15.903116');


--
-- TOC entry 1882 (class 0 OID 109380)
-- Dependencies: 1509
-- Data for Name: SecurityGroupToSecurityResource; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (31, 1, 'Basic');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (33, 1, 'News');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (34, 1, 'Member');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (35, 1, 'Forum');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (40, 1, 'Member Update');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (44, 3, 'Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (111, 1, 'Blog');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (149, 3, 'Blog');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (150, 3, 'Blog Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (151, 3, 'Cache Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (157, 3, 'Feedback Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (158, 3, 'Forum');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (159, 3, 'Forum Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (163, 3, 'Member');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (164, 3, 'Member Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (165, 3, 'Member Update');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (167, 3, 'News');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (168, 3, 'News Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (186, 3, 'Security Group Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (187, 3, 'Security Resource Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (255, 3, 'Basic');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (256, 3, 'Client Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (258, 3, 'Store');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (259, 3, 'Store Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (260, 1, 'Store');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (261, 3, 'Client');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (262, 3, 'Feedback');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (265, 1, 'Client');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (266, 1, 'Feedback');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (269, 3, 'Advanced Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (263, 3, 'Gallery');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (267, 1, 'Gallery');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (173, 3, 'Gallery Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (270, 3, 'Tag Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (264, 3, 'Tour');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (268, 1, 'Tour');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (257, 3, 'Tour Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (271, 1, 'Donation');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (272, 3, 'Donation');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (273, 3, 'Donation Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (277, 3, 'Sponsorship');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (278, 3, 'Sponsorship Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (279, 1, 'Sponsorship');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (280, 3, 'Country Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (274, 3, 'Comments');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (276, 1, 'Comments');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (275, 3, 'Comments Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (281, 3, 'Event Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (299, 31, 'Basic');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (300, 31, 'Member Update');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (301, 31, 'Tour');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (302, 31, 'Donation');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (304, 31, 'News');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (305, 31, 'Client');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (306, 31, 'Feedback');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (307, 31, 'Blog');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (308, 31, 'Sponsorship');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (309, 31, 'Gallery');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (310, 31, 'Comments');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (311, 31, 'Forum');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (312, 31, 'Store');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (313, 31, 'Blog Post');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (317, 31, 'Admin');
INSERT INTO "SecurityGroupToSecurityResource" ("Id", "SecurityGroupId", "SecurityResourceName") VALUES (318, 3, 'Blog Post');


--
-- TOC entry 1883 (class 0 OID 109390)
-- Dependencies: 1512
-- Data for Name: SecurityResource; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (26, 'Cache Admin', 'Cache Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (34, 'Feedback Admin', 'Feedback Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (47, 'Blog Admin', 'Blog Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (48, 'Blog', 'Blog');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (57, 'Client Admin', 'Client Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (59, 'Store', 'Store');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (60, 'Store Admin', 'Store Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (19, 'Security Group Admin', 'Security Group Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (25, 'Security Resource Admin', 'Security Resource Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (13, 'News Admin', 'News Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (4, 'News', 'News');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (23, 'Member Update', 'Member Update');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (12, 'Member Admin', 'Member Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (3, 'Member', 'Member');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (11, 'Forum Admin', 'Forum Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (2, 'Forum', 'Forum');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (24, 'Admin', 'General admin group to gain access to the admin home page');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (1, 'Basic', 'General admin group to gain access to the Web site home page');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (62, 'Client', 'Client');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (63, 'Feedback', 'Feedback');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (65, 'Advanced Admin', 'Advanced Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (64, 'Gallery', 'Gallery');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (52, 'Gallery Admin', 'Gallery Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (66, 'Tag Admin', 'Tag Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (61, 'Tour', 'Tour');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (58, 'Tour Admin', 'Tour Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (68, 'Donation', 'Donation');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (67, 'Donation Admin', 'Donation Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (71, 'Sponsorship Admin', 'Sponsorship Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (72, 'Sponsorship', 'Sponsorship');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (73, 'Country Admin', 'Country Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (70, 'Comments', 'Comments');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (69, 'Comments Admin', 'Comments Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (74, 'Event Admin', 'Event Admin');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (49, 'Blog Post', 'Blog Post');
INSERT INTO "SecurityResource" ("Id", "Name", "Description") VALUES (75, 'Blogs Admin', 'Access to the administration of Blogs, as in multiple blogs and not the Blog navigation index');


--
-- TOC entry 1884 (class 0 OID 109398)
-- Dependencies: 1514
-- Data for Name: Setting; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1885 (class 0 OID 109406)
-- Dependencies: 1516
-- Data for Name: Tag; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1886 (class 0 OID 109412)
-- Dependencies: 1517
-- Data for Name: TagToData; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1872 (class 2606 OID 109580)
-- Dependencies: 1523 1523
-- Name: BinaryCrop_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "BinaryCrop"
    ADD CONSTRAINT "BinaryCrop_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1826 (class 2606 OID 109439)
-- Dependencies: 1504 1504
-- Name: Blobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Binary"
    ADD CONSTRAINT "Blobs_pkey" PRIMARY KEY ("Id");


-- TOC entry 1866 (class 2606 OID 109552)
-- Dependencies: 1520 1520 1520
-- Name: MembersToSecurityGroups_MemberId_SecurityGroupId_uniq; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "MemberToSecurityGroup"
    ADD CONSTRAINT "MembersToSecurityGroups_MemberId_SecurityGroupId_uniq" UNIQUE ("MemberId", "SecurityGroupId");


--
-- TOC entry 1869 (class 2606 OID 109554)
-- Dependencies: 1520 1520
-- Name: MembersToSecurityGroups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "MemberToSecurityGroup"
    ADD CONSTRAINT "MembersToSecurityGroups_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1832 (class 2606 OID 109451)
-- Dependencies: 1506 1506
-- Name: Members_Id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Member"
    ADD CONSTRAINT "Members_Id" PRIMARY KEY ("Id");


--
-- TOC entry 1839 (class 2606 OID 109453)
-- Dependencies: 1509 1509 1509
-- Name: SecurityGroupsToSecurityResources_SecurityGroupId_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "SecurityGroupToSecurityResource"
    ADD CONSTRAINT "SecurityGroupsToSecurityResources_SecurityGroupId_key" UNIQUE ("SecurityGroupId", "SecurityResourceName");


--
-- TOC entry 1842 (class 2606 OID 109455)
-- Dependencies: 1509 1509
-- Name: SecurityGroupsToSecurityResources_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "SecurityGroupToSecurityResource"
    ADD CONSTRAINT "SecurityGroupsToSecurityResources_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1837 (class 2606 OID 109457)
-- Dependencies: 1508 1508
-- Name: SecurityGroups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "SecurityGroup"
    ADD CONSTRAINT "SecurityGroups_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1844 (class 2606 OID 109459)
-- Dependencies: 1512 1512
-- Name: SecurityResources_Name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "SecurityResource"
    ADD CONSTRAINT "SecurityResources_Name_key" UNIQUE ("Name");


--
-- TOC entry 1846 (class 2606 OID 109461)
-- Dependencies: 1512 1512
-- Name: SecurityResources_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "SecurityResource"
    ADD CONSTRAINT "SecurityResources_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1850 (class 2606 OID 109463)
-- Dependencies: 1514 1514 1514 1514
-- Name: Settings_MemberId_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Setting"
    ADD CONSTRAINT "Settings_MemberId_key" UNIQUE ("MemberId", "Name", "Value");


--
-- TOC entry 1852 (class 2606 OID 109465)
-- Dependencies: 1514 1514
-- Name: Settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Setting"
    ADD CONSTRAINT "Settings_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1863 (class 2606 OID 109467)
-- Dependencies: 1517 1517
-- Name: TagToData_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "TagToData"
    ADD CONSTRAINT "TagToData_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1854 (class 2606 OID 109469)
-- Dependencies: 1516 1516
-- Name: Tag_Tag_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Tag"
    ADD CONSTRAINT "Tag_Tag_key" UNIQUE ("Tag");


--
-- TOC entry 1858 (class 2606 OID 109471)
-- Dependencies: 1516 1516
-- Name: Tags_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace:
--

ALTER TABLE ONLY "Tag"
    ADD CONSTRAINT "Tags_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 1870 (class 1259 OID 109581)
-- Dependencies: 1523
-- Name: BinaryCrop_Id_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "BinaryCrop_Id_idx" ON "BinaryCrop" USING btree ("Id");


--
-- TOC entry 1864 (class 1259 OID 109555)
-- Dependencies: 1520
-- Name: MembersToSecurityGroups_MemberId_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "MembersToSecurityGroups_MemberId_Idx" ON "MemberToSecurityGroup" USING btree ("MemberId");


--
-- TOC entry 1867 (class 1259 OID 109556)
-- Dependencies: 1520
-- Name: MembersToSecurityGroups_SecurityGroupId_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "MembersToSecurityGroups_SecurityGroupId_Idx" ON "MemberToSecurityGroup" USING btree ("SecurityGroupId");


--
-- TOC entry 1827 (class 1259 OID 109493)
-- Dependencies: 1506
-- Name: Members_Alias_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Members_Alias_Idx" ON "Member" USING btree ("Alias" varchar_ops);


--
-- TOC entry 1828 (class 1259 OID 109494)
-- Dependencies: 1506
-- Name: Members_AuthId_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Members_AuthId_Idx" ON "Member" USING btree ("AuthId" varchar_ops);


--
-- TOC entry 1829 (class 1259 OID 109495)
-- Dependencies: 1506
-- Name: Members_DateCreated_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Members_DateCreated_Idx" ON "Member" USING btree ("DateCreated");


--
-- TOC entry 1830 (class 1259 OID 109496)
-- Dependencies: 1506
-- Name: Members_EmailAddress_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE UNIQUE INDEX "Members_EmailAddress_Idx" ON "Member" USING btree ("EmailAddress" varchar_ops);


--
-- TOC entry 1833 (class 1259 OID 109497)
-- Dependencies: 1506
-- Name: Members_ImageId_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Members_ImageId_Idx" ON "Member" USING btree ("ImageId");


--
-- TOC entry 1834 (class 1259 OID 109498)
-- Dependencies: 1506
-- Name: Members_LastVisit_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Members_LastVisit_Idx" ON "Member" USING btree ("LastVisit");


--
-- TOC entry 1840 (class 1259 OID 109499)
-- Dependencies: 1509
-- Name: SecurityGroupsToSecurityResources_SecurityResourceName_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "SecurityGroupsToSecurityResources_SecurityResourceName_Idx" ON "SecurityGroupToSecurityResource" USING btree ("SecurityResourceName");


--
-- TOC entry 1835 (class 1259 OID 109500)
-- Dependencies: 1508
-- Name: SecurityGroups_DateCreated_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "SecurityGroups_DateCreated_Idx" ON "SecurityGroup" USING btree ("DateCreated");


--
-- TOC entry 1847 (class 1259 OID 109501)
-- Dependencies: 1514
-- Name: Settings_MemberId_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Settings_MemberId_Idx" ON "Setting" USING btree ("MemberId");


--
-- TOC entry 1848 (class 1259 OID 109502)
-- Dependencies: 1514 1514
-- Name: Settings_MemberId_Name_Idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Settings_MemberId_Name_Idx" ON "Setting" USING btree ("MemberId", "Name");


--
-- TOC entry 1859 (class 1259 OID 109503)
-- Dependencies: 1517
-- Name: TagToData_DataId_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "TagToData_DataId_idx" ON "TagToData" USING btree ("DataId");


--
-- TOC entry 1860 (class 1259 OID 109504)
-- Dependencies: 1517
-- Name: TagToData_Tag_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "TagToData_Tag_idx" ON "TagToData" USING btree ("Tag");


--
-- TOC entry 1861 (class 1259 OID 109505)
-- Dependencies: 1517
-- Name: TagToData_Type_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "TagToData_Type_idx" ON "TagToData" USING btree ("Type");


--
-- TOC entry 1855 (class 1259 OID 109506)
-- Dependencies: 1516
-- Name: Tags_Tag_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Tags_Tag_idx" ON "Tag" USING btree ("Tag");


--
-- TOC entry 1856 (class 1259 OID 109507)
-- Dependencies: 1516
-- Name: Tags_TextIndex_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace:
--

CREATE INDEX "Tags_TextIndex_idx" ON "Tag" USING gist ("TextIndex");


--
-- TOC entry 1876 (class 2606 OID 109557)
-- Dependencies: 1520 1831 1506
-- Name: MemberToSecurityGroups_MemberId->Members_Id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "MemberToSecurityGroup"
    ADD CONSTRAINT "MemberToSecurityGroups_MemberId->Members_Id" FOREIGN KEY ("MemberId") REFERENCES "Member"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1877 (class 2606 OID 109562)
-- Dependencies: 1520 1836 1508
-- Name: MembersToSecurityGroups_SecurityGroupId->SecurityGroups_Id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "MemberToSecurityGroup"
    ADD CONSTRAINT "MembersToSecurityGroups_SecurityGroupId->SecurityGroups_Id" FOREIGN KEY ("SecurityGroupId") REFERENCES "SecurityGroup"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1873 (class 2606 OID 109528)
-- Dependencies: 1509 1508 1836
-- Name: SecurityGroupsToSecurityResources_SecurityGroupId->SecurityGrou; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "SecurityGroupToSecurityResource"
    ADD CONSTRAINT "SecurityGroupsToSecurityResources_SecurityGroupId->SecurityGrou" FOREIGN KEY ("SecurityGroupId") REFERENCES "SecurityGroup"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1874 (class 2606 OID 109533)
-- Dependencies: 1512 1843 1509
-- Name: SecurityGroupsToSecurityResources_SecurityResourceName->Securit; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "SecurityGroupToSecurityResource"
    ADD CONSTRAINT "SecurityGroupsToSecurityResources_SecurityResourceName->Securit" FOREIGN KEY ("SecurityResourceName") REFERENCES "SecurityResource"("Name") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1875 (class 2606 OID 109538)
-- Dependencies: 1514 1831 1506
-- Name: Settings_MemberId->Members_Id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Setting"
    ADD CONSTRAINT "Settings_MemberId->Members_Id" FOREIGN KEY ("MemberId") REFERENCES "Member"("Id") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1893 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- TOC entry 1894 (class 0 OID 0)
-- Dependencies: 1504
-- Name: Binary; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Binary" FROM PUBLIC;
REVOKE ALL ON TABLE "Binary" FROM postgres;
GRANT ALL ON TABLE "Binary" TO postgres;
GRANT ALL ON TABLE "Binary" TO "WebUserGroup";


--
-- TOC entry 1895 (class 0 OID 0)
-- Dependencies: 1523
-- Name: BinaryCrop; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "BinaryCrop" FROM PUBLIC;
GRANT ALL ON TABLE "BinaryCrop" TO "WebUserGroup";


--
-- TOC entry 1898 (class 0 OID 0)
-- Dependencies: 1522
-- Name: BinaryCrop_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "BinaryCrop_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "BinaryCrop_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "BinaryCrop_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "BinaryCrop_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1901 (class 0 OID 0)
-- Dependencies: 1505
-- Name: Binary_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "Binary_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "Binary_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "Binary_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "Binary_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1906 (class 0 OID 0)
-- Dependencies: 1506
-- Name: Member; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Member" FROM PUBLIC;
REVOKE ALL ON TABLE "Member" FROM postgres;
GRANT ALL ON TABLE "Member" TO postgres;
GRANT ALL ON TABLE "Member" TO "WebUserGroup";


--
-- TOC entry 1907 (class 0 OID 0)
-- Dependencies: 1520
-- Name: MemberToSecurityGroup; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "MemberToSecurityGroup" FROM PUBLIC;
REVOKE ALL ON TABLE "MemberToSecurityGroup" FROM postgres;
GRANT ALL ON TABLE "MemberToSecurityGroup" TO postgres;
GRANT ALL ON TABLE "MemberToSecurityGroup" TO "WebUserGroup";


--
-- TOC entry 1910 (class 0 OID 0)
-- Dependencies: 1521
-- Name: MemberToSecurityGroup_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "MemberToSecurityGroup_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "MemberToSecurityGroup_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "MemberToSecurityGroup_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "MemberToSecurityGroup_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1913 (class 0 OID 0)
-- Dependencies: 1507
-- Name: Member_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "Member_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "Member_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "Member_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "Member_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1914 (class 0 OID 0)
-- Dependencies: 1508
-- Name: SecurityGroup; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "SecurityGroup" FROM PUBLIC;
REVOKE ALL ON TABLE "SecurityGroup" FROM postgres;
GRANT ALL ON TABLE "SecurityGroup" TO postgres;
GRANT ALL ON TABLE "SecurityGroup" TO "WebUserGroup";


--
-- TOC entry 1915 (class 0 OID 0)
-- Dependencies: 1509
-- Name: SecurityGroupToSecurityResource; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "SecurityGroupToSecurityResource" FROM PUBLIC;
REVOKE ALL ON TABLE "SecurityGroupToSecurityResource" FROM postgres;
GRANT ALL ON TABLE "SecurityGroupToSecurityResource" TO postgres;
GRANT ALL ON TABLE "SecurityGroupToSecurityResource" TO "WebUserGroup";


--
-- TOC entry 1918 (class 0 OID 0)
-- Dependencies: 1510
-- Name: SecurityGroupToSecurityResource_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "SecurityGroupToSecurityResource_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "SecurityGroupToSecurityResource_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "SecurityGroupToSecurityResource_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "SecurityGroupToSecurityResource_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1921 (class 0 OID 0)
-- Dependencies: 1511
-- Name: SecurityGroup_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "SecurityGroup_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "SecurityGroup_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "SecurityGroup_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "SecurityGroup_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1922 (class 0 OID 0)
-- Dependencies: 1512
-- Name: SecurityResource; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "SecurityResource" FROM PUBLIC;
REVOKE ALL ON TABLE "SecurityResource" FROM postgres;
GRANT ALL ON TABLE "SecurityResource" TO postgres;
GRANT ALL ON TABLE "SecurityResource" TO "WebUserGroup";


--
-- TOC entry 1925 (class 0 OID 0)
-- Dependencies: 1513
-- Name: SecurityResource_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "SecurityResource_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "SecurityResource_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "SecurityResource_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "SecurityResource_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1926 (class 0 OID 0)
-- Dependencies: 1514
-- Name: Setting; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Setting" FROM PUBLIC;
REVOKE ALL ON TABLE "Setting" FROM postgres;
GRANT ALL ON TABLE "Setting" TO postgres;
GRANT ALL ON TABLE "Setting" TO "WebUserGroup";


--
-- TOC entry 1929 (class 0 OID 0)
-- Dependencies: 1515
-- Name: Setting_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "Setting_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "Setting_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "Setting_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "Setting_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1930 (class 0 OID 0)
-- Dependencies: 1516
-- Name: Tag; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Tag" FROM PUBLIC;
REVOKE ALL ON TABLE "Tag" FROM postgres;
GRANT ALL ON TABLE "Tag" TO postgres;
GRANT ALL ON TABLE "Tag" TO "WebUserGroup";


--
-- TOC entry 1931 (class 0 OID 0)
-- Dependencies: 1517
-- Name: TagToData; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "TagToData" FROM PUBLIC;
REVOKE ALL ON TABLE "TagToData" FROM postgres;
GRANT ALL ON TABLE "TagToData" TO postgres;
GRANT ALL ON TABLE "TagToData" TO "WebUserGroup";


--
-- TOC entry 1934 (class 0 OID 0)
-- Dependencies: 1518
-- Name: TagToData_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "TagToData_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "TagToData_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "TagToData_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "TagToData_Id_seq" TO "WebUserGroup";


--
-- TOC entry 1937 (class 0 OID 0)
-- Dependencies: 1519
-- Name: Tag_Id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE "Tag_Id_seq" FROM PUBLIC;
REVOKE ALL ON SEQUENCE "Tag_Id_seq" FROM postgres;
GRANT ALL ON SEQUENCE "Tag_Id_seq" TO postgres;
GRANT ALL ON SEQUENCE "Tag_Id_seq" TO "WebUserGroup";


-- Completed on 2010-07-28 13:24:11 BST

--
-- PostgreSQL database dump complete
--

