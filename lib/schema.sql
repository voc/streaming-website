DROP TABLE IF EXISTS feedback;
CREATE TABLE feedback (
	reported NUMERIC,
	datetime NUMERIC,
	net TEXT,
	os TEXT,
	player TEXT,
	stream TEXT,
	ipproto_v4 NUMERIC,
	ipproto_v6 NUMERIC,
	provider TEXT,
	issues TEXT,
	issuetext TEXT
);
