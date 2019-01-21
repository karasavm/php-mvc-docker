CREATE TABLE public.users
(
    id serial NOT NULL,
    name character varying(100) COLLATE pg_catalog."default",
    company_id integer,
    email character varying(100) COLLATE pg_catalog."default" NOT NULL,
    password character varying(200) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT unique_email_constrain UNIQUE (email)
,
    CONSTRAINT users_company_id_fkey FOREIGN KEY (company_id)
        REFERENCES public.companies (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to mike;