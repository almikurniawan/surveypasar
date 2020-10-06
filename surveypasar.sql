--
-- PostgreSQL database dump
--

-- Dumped from database version 10.5
-- Dumped by pg_dump version 10.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id bigint NOT NULL,
    version character varying(255) NOT NULL,
    class text NOT NULL,
    "group" character varying(255) NOT NULL,
    namespace character varying(255) NOT NULL,
    "time" integer NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: ref_group_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_group_akses (
    ref_group_akses_id integer NOT NULL,
    ref_group_akses_label character varying(255)
);


ALTER TABLE public.ref_group_akses OWNER TO postgres;

--
-- Name: ref_group_akses_ref_group_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_group_akses_ref_group_akses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_group_akses_ref_group_akses_id_seq OWNER TO postgres;

--
-- Name: ref_group_akses_ref_group_akses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_group_akses_ref_group_akses_id_seq OWNED BY public.ref_group_akses.ref_group_akses_id;


--
-- Name: ref_modul_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_modul_akses (
    ref_modul_akses_id integer NOT NULL,
    ref_modul_akses_label character varying(255),
    ref_modul_akses_group_id integer
);


ALTER TABLE public.ref_modul_akses OWNER TO postgres;

--
-- Name: ref_modul_akses_ref_modul_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_modul_akses_ref_modul_akses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_modul_akses_ref_modul_akses_id_seq OWNER TO postgres;

--
-- Name: ref_modul_akses_ref_modul_akses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_modul_akses_ref_modul_akses_id_seq OWNED BY public.ref_modul_akses.ref_modul_akses_id;


--
-- Name: ref_pasar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_pasar (
    ref_pasar_id integer NOT NULL,
    ref_pasar_label character varying(255)
);


ALTER TABLE public.ref_pasar OWNER TO postgres;

--
-- Name: ref_pasar_ref_pasar_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_pasar_ref_pasar_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_pasar_ref_pasar_id_seq OWNER TO postgres;

--
-- Name: ref_pasar_ref_pasar_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_pasar_ref_pasar_id_seq OWNED BY public.ref_pasar.ref_pasar_id;


--
-- Name: ref_produk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_produk (
    ref_produk_id integer NOT NULL,
    ref_produk_label character varying
);


ALTER TABLE public.ref_produk OWNER TO postgres;

--
-- Name: ref_produk_ref_produk_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_produk_ref_produk_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_produk_ref_produk_id_seq OWNER TO postgres;

--
-- Name: ref_produk_ref_produk_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_produk_ref_produk_id_seq OWNED BY public.ref_produk.ref_produk_id;


--
-- Name: ref_produk_satuan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_produk_satuan (
    ref_produk_satuan_id integer NOT NULL,
    ref_produk_satuan_label character varying(255)
);


ALTER TABLE public.ref_produk_satuan OWNER TO postgres;

--
-- Name: ref_produk_satuan_ref_produk_satuan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_produk_satuan_ref_produk_satuan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_produk_satuan_ref_produk_satuan_id_seq OWNER TO postgres;

--
-- Name: ref_produk_satuan_ref_produk_satuan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_produk_satuan_ref_produk_satuan_id_seq OWNED BY public.ref_produk_satuan.ref_produk_satuan_id;


--
-- Name: ref_produk_varian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_produk_varian (
    ref_produk_var_id integer NOT NULL,
    ref_produk_var_label character varying,
    ref_produk_var_produk_id integer,
    ref_produk_var_satuan_id integer
);


ALTER TABLE public.ref_produk_varian OWNER TO postgres;

--
-- Name: ref_produk_variant_ref_produk_variant_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_produk_variant_ref_produk_variant_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_produk_variant_ref_produk_variant_id_seq OWNER TO postgres;

--
-- Name: ref_produk_variant_ref_produk_variant_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_produk_variant_ref_produk_variant_id_seq OWNED BY public.ref_produk_varian.ref_produk_var_id;


--
-- Name: ref_user_akses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ref_user_akses (
    ref_user_akses_id integer NOT NULL,
    ref_user_akses_user_id integer,
    ref_user_akses_group_id integer
);


ALTER TABLE public.ref_user_akses OWNER TO postgres;

--
-- Name: ref_user_akses_ref_user_akses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ref_user_akses_ref_user_akses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ref_user_akses_ref_user_akses_id_seq OWNER TO postgres;

--
-- Name: ref_user_akses_ref_user_akses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ref_user_akses_ref_user_akses_id_seq OWNED BY public.ref_user_akses.ref_user_akses_id;


--
-- Name: seller; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seller (
    seller_id integer NOT NULL,
    seller_nama character varying,
    seller_pasar_id integer,
    seller_alamat character varying,
    seller_no_hp character varying(255)
);


ALTER TABLE public.seller OWNER TO postgres;

--
-- Name: seller_produk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seller_produk (
    seller_prod_id integer NOT NULL,
    seller_prod_seller_id integer,
    seller_prod_produk_var_id integer
);


ALTER TABLE public.seller_produk OWNER TO postgres;

--
-- Name: seller_produk_seller_prod_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seller_produk_seller_prod_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seller_produk_seller_prod_id_seq OWNER TO postgres;

--
-- Name: seller_produk_seller_prod_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seller_produk_seller_prod_id_seq OWNED BY public.seller_produk.seller_prod_id;


--
-- Name: seller_seller_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seller_seller_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seller_seller_id_seq OWNER TO postgres;

--
-- Name: seller_seller_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seller_seller_id_seq OWNED BY public.seller.seller_id;


--
-- Name: survey_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.survey_detail (
    survey_det_id integer NOT NULL,
    survey_det_head_id integer,
    survey_det_tanggal date,
    survey_det_seller_id integer,
    survey_det_produk_var_id integer,
    survey_det_harga real DEFAULT 0,
    survey_det_created_at timestamp(6) without time zone DEFAULT now(),
    survey_det_created_by integer
);


ALTER TABLE public.survey_detail OWNER TO postgres;

--
-- Name: survey_detail_survey_det_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.survey_detail_survey_det_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.survey_detail_survey_det_id_seq OWNER TO postgres;

--
-- Name: survey_detail_survey_det_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.survey_detail_survey_det_id_seq OWNED BY public.survey_detail.survey_det_id;


--
-- Name: survey_header; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.survey_header (
    survey_head_id integer NOT NULL,
    survey_head_tanggal date,
    survey_head_seller_id integer,
    survey_head_created_at timestamp without time zone DEFAULT now(),
    survey_head_created_by integer,
    survey_head_approve_is boolean,
    survey_head_approve_at timestamp without time zone,
    survey_head_approve_by integer,
    survey_head_reject_is boolean,
    survey_head_reject_at timestamp(6) without time zone,
    survey_head_reject_by integer
);


ALTER TABLE public.survey_header OWNER TO postgres;

--
-- Name: survey_header_survey_head_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.survey_header_survey_head_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.survey_header_survey_head_id_seq OWNER TO postgres;

--
-- Name: survey_header_survey_head_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.survey_header_survey_head_id_seq OWNED BY public.survey_header.survey_head_id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."user" (
    user_id integer NOT NULL,
    user_name character varying,
    user_password character varying(255),
    user_kar_id integer,
    user_disable boolean,
    user_created_at timestamp(6) without time zone,
    user_namalengkap character varying(255)
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- Name: user_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_user_id_seq OWNER TO postgres;

--
-- Name: user_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_user_id_seq OWNED BY public."user".user_id;


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: ref_group_akses ref_group_akses_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_group_akses ALTER COLUMN ref_group_akses_id SET DEFAULT nextval('public.ref_group_akses_ref_group_akses_id_seq'::regclass);


--
-- Name: ref_modul_akses ref_modul_akses_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_modul_akses ALTER COLUMN ref_modul_akses_id SET DEFAULT nextval('public.ref_modul_akses_ref_modul_akses_id_seq'::regclass);


--
-- Name: ref_pasar ref_pasar_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_pasar ALTER COLUMN ref_pasar_id SET DEFAULT nextval('public.ref_pasar_ref_pasar_id_seq'::regclass);


--
-- Name: ref_produk ref_produk_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_produk ALTER COLUMN ref_produk_id SET DEFAULT nextval('public.ref_produk_ref_produk_id_seq'::regclass);


--
-- Name: ref_produk_satuan ref_produk_satuan_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_produk_satuan ALTER COLUMN ref_produk_satuan_id SET DEFAULT nextval('public.ref_produk_satuan_ref_produk_satuan_id_seq'::regclass);


--
-- Name: ref_produk_varian ref_produk_var_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_produk_varian ALTER COLUMN ref_produk_var_id SET DEFAULT nextval('public.ref_produk_variant_ref_produk_variant_id_seq'::regclass);


--
-- Name: ref_user_akses ref_user_akses_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_user_akses ALTER COLUMN ref_user_akses_id SET DEFAULT nextval('public.ref_user_akses_ref_user_akses_id_seq'::regclass);


--
-- Name: seller seller_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seller ALTER COLUMN seller_id SET DEFAULT nextval('public.seller_seller_id_seq'::regclass);


--
-- Name: seller_produk seller_prod_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seller_produk ALTER COLUMN seller_prod_id SET DEFAULT nextval('public.seller_produk_seller_prod_id_seq'::regclass);


--
-- Name: survey_detail survey_det_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.survey_detail ALTER COLUMN survey_det_id SET DEFAULT nextval('public.survey_detail_survey_det_id_seq'::regclass);


--
-- Name: survey_header survey_head_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.survey_header ALTER COLUMN survey_head_id SET DEFAULT nextval('public.survey_header_survey_head_id_seq'::regclass);


--
-- Name: user user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user" ALTER COLUMN user_id SET DEFAULT nextval('public.user_user_id_seq'::regclass);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, version, class, "group", namespace, "time", batch) FROM stdin;
1	2020-09-18-085812	App\\Database\\Migrations\\Database	default	App	1600419560	1
\.


--
-- Data for Name: ref_group_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_group_akses (ref_group_akses_id, ref_group_akses_label) FROM stdin;
1	Admin
2	Surveyor
4	Approval
\.


--
-- Data for Name: ref_modul_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_modul_akses (ref_modul_akses_id, ref_modul_akses_label, ref_modul_akses_group_id) FROM stdin;
2	admin/aksesModul	1
3	admin/survey	2
4	admin/rekap	4
5	admin/validasi	4
6	#referensi	1
7	admin/refPasar	1
8	admin/refProduk	1
9	admin/refProdukSatuan	1
10	admin/refProdukVarian	1
11	admin/refSeller	1
12	#akses	1
13	admin/aksesGroup	1
14	admin/aksesModul	1
15	admin/aksesUser	1
16	admin/notifikasi	2
17	admin/notifikasi	1
\.


--
-- Data for Name: ref_pasar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_pasar (ref_pasar_id, ref_pasar_label) FROM stdin;
3	Pasar Bandar
4	Pasar Dandangan
5	Pasar Induk
7	Pasar Pahing
\.


--
-- Data for Name: ref_produk; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_produk (ref_produk_id, ref_produk_label) FROM stdin;
4	GULA PASIR
2	MINYAK GORENG
1	BERAS
3	DAGING
5	KRUPUK
\.


--
-- Data for Name: ref_produk_satuan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_produk_satuan (ref_produk_satuan_id, ref_produk_satuan_label) FROM stdin;
2	KG
3	CM
4	Liter
5	Dus
\.


--
-- Data for Name: ref_produk_varian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_produk_varian (ref_produk_var_id, ref_produk_var_label, ref_produk_var_produk_id, ref_produk_var_satuan_id) FROM stdin;
1	Bengawan	1	\N
2	Mentik	1	\N
3	IR 64	1	\N
4	Gula Pasir Dalam Negri	4	\N
5	Bimoli Botol / Kemasan (Sps) 620 ml	2	\N
6	Bimoli botol/Kemasan (sps) 2 liter	2	\N
7	Tanpa Merk / Minyak Curah	2	\N
8	Minyak Goreng Bimoli Botol/Kemasan (sps) 1 Liter	2	\N
9	Daging Sapi Murni	3	\N
10	Daging Ayam Broiler	3	\N
11	Daging Ayam Kampung	3	2
12	Krupuk Bawang	5	5
\.


--
-- Data for Name: ref_user_akses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ref_user_akses (ref_user_akses_id, ref_user_akses_user_id, ref_user_akses_group_id) FROM stdin;
4	3	1
5	3	2
6	3	3
7	2	2
20	1	1
21	1	2
22	1	4
\.


--
-- Data for Name: seller; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seller (seller_id, seller_nama, seller_pasar_id, seller_alamat, seller_no_hp) FROM stdin;
4	Arsy	4	test	123123
7	Siti	5	kediri	892735973
3	Fara	3	Tulungagung	08832131874321
6	Siti	4	kediri	08986745
5	Liyan	3	Kediri	089867576
2	Yusuf	4	Punjul	45312123141234
1	Almi	5	Manukan Jabon	0999789
8	Farhan	7	Kediri	0875456789
\.


--
-- Data for Name: seller_produk; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seller_produk (seller_prod_id, seller_prod_seller_id, seller_prod_produk_var_id) FROM stdin;
1	1	1
2	1	2
3	1	3
4	1	4
5	1	5
6	1	6
7	1	7
8	1	8
9	1	9
10	1	10
11	1	11
12	2	1
13	2	2
14	2	3
15	2	4
16	2	5
17	2	6
18	2	7
19	2	8
20	2	9
21	2	10
22	2	11
23	3	11
24	3	10
25	3	9
26	3	7
27	3	5
28	3	4
29	3	2
30	3	3
31	5	11
32	5	9
33	5	7
34	5	8
35	5	10
36	5	5
37	4	11
38	4	9
39	4	8
40	4	7
41	4	6
42	4	10
43	4	4
44	7	4
45	7	6
46	7	8
47	7	10
48	7	12
49	7	11
50	6	12
51	6	11
52	6	11
53	6	10
54	6	9
55	6	8
56	6	8
57	6	7
58	6	6
59	6	5
60	8	11
61	8	10
62	8	12
63	8	9
\.


--
-- Data for Name: survey_detail; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.survey_detail (survey_det_id, survey_det_head_id, survey_det_tanggal, survey_det_seller_id, survey_det_produk_var_id, survey_det_harga, survey_det_created_at, survey_det_created_by) FROM stdin;
115	19	2020-09-17	8	9	100000	2020-09-17 16:03:52.200776	1
116	19	2020-09-17	8	10	35000	2020-09-17 16:03:52.200776	1
117	19	2020-09-17	8	11	50000	2020-09-17 16:03:52.200776	1
160	22	2020-09-16	2	4	9	2020-09-25 15:26:32.113647	1
161	22	2020-09-16	2	5	69	2020-09-25 15:26:32.113647	1
162	22	2020-09-16	2	6	69	2020-09-25 15:26:32.113647	1
163	22	2020-09-16	2	7	69	2020-09-25 15:26:32.113647	1
164	22	2020-09-16	2	8	6	2020-09-25 15:26:32.113647	1
165	22	2020-09-16	2	9	97	2020-09-25 15:26:32.113647	1
166	22	2020-09-16	2	10	9	2020-09-25 15:26:32.113647	1
167	22	2020-09-16	2	11	669	2020-09-25 15:26:32.113647	1
179	23	2020-09-26	1	1	67890	2020-09-26 09:25:51.791381	1
180	23	2020-09-26	1	2	67890	2020-09-26 09:25:51.791381	1
181	23	2020-09-26	1	3	87654	2020-09-26 09:25:51.791381	1
182	23	2020-09-26	1	4	34567	2020-09-26 09:25:51.791381	1
183	23	2020-09-26	1	5	876	2020-09-26 09:25:51.791381	1
184	23	2020-09-26	1	6	5678	2020-09-26 09:25:51.791381	1
185	23	2020-09-26	1	7	9876	2020-09-26 09:25:51.791381	1
186	23	2020-09-26	1	8	6789	2020-09-26 09:25:51.791381	1
187	23	2020-09-26	1	9	78687	2020-09-26 09:25:51.791381	1
188	23	2020-09-26	1	10	565	2020-09-26 09:25:51.791381	1
189	23	2020-09-26	1	11	100000	2020-09-26 09:25:51.791381	1
197	24	2020-09-28	1	8	787	2020-09-26 14:37:36.609199	1
198	24	2020-09-28	1	9	787	2020-09-26 14:37:36.609199	1
199	24	2020-09-28	1	10	787	2020-09-26 14:37:36.609199	1
200	24	2020-09-28	1	11	787	2020-09-26 14:37:36.609199	1
118	19	2020-09-17	8	12	10000	2020-09-17 16:03:52.200776	2
130	21	2020-09-24	2	1	10000	2020-09-24 09:29:11.622656	2
131	21	2020-09-24	2	2	969	2020-09-24 09:29:11.622656	2
132	21	2020-09-24	2	3	65690	2020-09-24 09:29:11.622656	2
151	20	2020-09-17	1	1	10000	2020-09-25 15:23:32.126968	2
152	20	2020-09-17	1	2	9000	2020-09-25 15:23:32.126968	2
153	20	2020-09-17	1	3	9400	2020-09-25 15:23:32.126968	2
154	20	2020-09-17	1	4	10000	2020-09-25 15:23:32.126968	2
155	20	2020-09-17	1	5	900000	2020-09-25 15:23:32.126968	2
156	20	2020-09-17	1	6	700000	2020-09-25 15:23:32.126968	2
157	22	2020-09-16	2	1	9000	2020-09-25 15:26:32.113647	2
158	22	2020-09-16	2	2	76789	2020-09-25 15:26:32.113647	2
159	22	2020-09-16	2	3	9959	2020-09-25 15:26:32.113647	2
190	24	2020-09-28	1	1	7896	2020-09-26 14:37:36.609199	3
191	24	2020-09-28	1	2	787	2020-09-26 14:37:36.609199	3
192	24	2020-09-28	1	3	787	2020-09-26 14:37:36.609199	3
193	24	2020-09-28	1	4	787	2020-09-26 14:37:36.609199	3
194	24	2020-09-28	1	5	787787	2020-09-26 14:37:36.609199	3
195	24	2020-09-28	1	6	787	2020-09-26 14:37:36.609199	3
196	24	2020-09-28	1	7	787	2020-09-26 14:37:36.609199	3
\.


--
-- Data for Name: survey_header; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.survey_header (survey_head_id, survey_head_tanggal, survey_head_seller_id, survey_head_created_at, survey_head_created_by, survey_head_approve_is, survey_head_approve_at, survey_head_approve_by, survey_head_reject_is, survey_head_reject_at, survey_head_reject_by) FROM stdin;
19	2020-09-17	8	2020-09-17 16:03:52.136395	1	t	2020-09-25 03:23:08	1	\N	\N	\N
21	2020-09-24	2	2020-09-24 09:29:11.58319	1	\N	\N	\N	t	2020-09-25 03:23:15	1
20	2020-09-17	1	2020-09-17 16:04:18.309015	1	t	2020-09-25 03:25:04	1	\N	\N	\N
22	2020-09-16	2	2020-09-25 15:26:32.091558	1	t	2020-09-25 03:26:48	1	\N	\N	\N
23	2020-09-26	1	2020-09-26 09:25:31.397972	1	t	2020-09-25 21:28:02	1	\N	\N	\N
24	2020-09-28	1	2020-09-26 14:37:36.447004	1	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."user" (user_id, user_name, user_password, user_kar_id, user_disable, user_created_at, user_namalengkap) FROM stdin;
3	wina	2fee5e53252cce3b7146551b6459fc99c3e28041	\N	\N	\N	wina
2	surveyor	d033e22ae348aeb5660fc2140aec35850c4da997	0	f	2020-09-16 10:34:30.089515	Almi
1	admin	d033e22ae348aeb5660fc2140aec35850c4da997	0	f	2020-09-16 10:34:30.089515	Yusuf
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 1, true);


--
-- Name: ref_group_akses_ref_group_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_group_akses_ref_group_akses_id_seq', 4, true);


--
-- Name: ref_modul_akses_ref_modul_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_modul_akses_ref_modul_akses_id_seq', 18, true);


--
-- Name: ref_pasar_ref_pasar_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_pasar_ref_pasar_id_seq', 7, true);


--
-- Name: ref_produk_ref_produk_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_produk_ref_produk_id_seq', 5, true);


--
-- Name: ref_produk_satuan_ref_produk_satuan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_produk_satuan_ref_produk_satuan_id_seq', 5, true);


--
-- Name: ref_produk_variant_ref_produk_variant_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_produk_variant_ref_produk_variant_id_seq', 12, true);


--
-- Name: ref_user_akses_ref_user_akses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ref_user_akses_ref_user_akses_id_seq', 22, true);


--
-- Name: seller_produk_seller_prod_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seller_produk_seller_prod_id_seq', 63, true);


--
-- Name: seller_seller_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seller_seller_id_seq', 8, true);


--
-- Name: survey_detail_survey_det_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.survey_detail_survey_det_id_seq', 200, true);


--
-- Name: survey_header_survey_head_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.survey_header_survey_head_id_seq', 24, true);


--
-- Name: user_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_user_id_seq', 3, true);


--
-- Name: migrations pk_migrations; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT pk_migrations PRIMARY KEY (id);


--
-- Name: ref_group_akses ref_group_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_group_akses
    ADD CONSTRAINT ref_group_akses_pkey PRIMARY KEY (ref_group_akses_id);


--
-- Name: ref_modul_akses ref_modul_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_modul_akses
    ADD CONSTRAINT ref_modul_akses_pkey PRIMARY KEY (ref_modul_akses_id);


--
-- Name: ref_produk ref_produk_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_produk
    ADD CONSTRAINT ref_produk_pkey PRIMARY KEY (ref_produk_id);


--
-- Name: ref_user_akses ref_user_akses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ref_user_akses
    ADD CONSTRAINT ref_user_akses_pkey PRIMARY KEY (ref_user_akses_id);


--
-- Name: seller_produk seller_produk_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seller_produk
    ADD CONSTRAINT seller_produk_pkey PRIMARY KEY (seller_prod_id);


--
-- Name: survey_detail survey_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.survey_detail
    ADD CONSTRAINT survey_detail_pkey PRIMARY KEY (survey_det_id);


--
-- Name: survey_header survey_head_uniq; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.survey_header
    ADD CONSTRAINT survey_head_uniq UNIQUE (survey_head_tanggal, survey_head_seller_id);


--
-- Name: survey_header survey_header_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.survey_header
    ADD CONSTRAINT survey_header_pkey PRIMARY KEY (survey_head_id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- PostgreSQL database dump complete
--

