CREATE INDEX points_ll_to_earth_idx ON public.points USING gist (ll_to_earth(lat, lon));
