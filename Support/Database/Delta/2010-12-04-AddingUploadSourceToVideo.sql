ALTER TABLE "Video" ADD COLUMN "UploadSource" text;

UPDATE "Video" SET "UploadSource" = 'flash';