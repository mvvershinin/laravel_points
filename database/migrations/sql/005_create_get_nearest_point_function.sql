CREATE OR REPLACE FUNCTION public.get_nearest_points(exists_lat double precision, exists_lon double precision, distance integer)
 RETURNS TABLE(id bigint, lat double precision, lon double precision, address_id integer, user_id integer, created_at timestamp without time zone, updated_at timestamp without time zone)
 LANGUAGE plpgsql
AS $function$
begin
return query
SELECT
    *
--	id,
--	lat,
--	lon,
--	address_id,
--	user_id,
--	created_at,
--	updated_at

from
    points 	p
where
    earth_box(ll_to_earth(exists_lat, exists_lon), distance) @> ll_to_earth(p.lat, p.lon)
  and
    p.address_id is not null;
end;$function$
;
