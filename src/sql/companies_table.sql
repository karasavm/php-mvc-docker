-- Table: public.companies

-- DROP TABLE public.companies;

CREATE TABLE public.companies
(
    id integer NOT NULL DEFAULT nextval('company_id_seq'::regclass),
    name character varying(100) COLLATE pg_catalog."default",
    lat_lon character varying(50) COLLATE pg_catalog."default",
    CONSTRAINT company_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.companies
    OWNER to mike;