ALTER TABLE "Video" ADD COLUMN "Rating" integer;

UPDATE "Video" SET "Rating" = 0;