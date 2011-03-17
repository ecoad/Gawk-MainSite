CREATE INDEX "Wall_Id_idx"
   ON "Wall" ("SecureId" ASC NULLS LAST);

   
CREATE INDEX "Wall_DateCreated_idx"
   ON "Wall" ("DateCreated" ASC NULLS LAST);
   
CREATE INDEX "Video_SecureId_idx"
   ON "Video" ("SecureId" ASC NULLS LAST);
   
CREATE INDEX "Video_Approved_idx"
   ON "Video" ("Approved" ASC NULLS LAST);
   
CREATE INDEX "Video_Rating_idx"
   ON "Video" ("Rating" ASC NULLS LAST);
   
CREATE INDEX "Video_UploadSource_idx"
   ON "Video" ("UploadSource" ASC NULLS LAST);