ALTER TABLE "Wall" ADD CONSTRAINT "Wall_SecureId_unique" UNIQUE ("SecureId");

ALTER TABLE "Wall" ADD CONSTRAINT "Wall_MemberSecureId_fkey" FOREIGN KEY ("MemberSecureId") REFERENCES "Member" ("SecureId")
   ON UPDATE CASCADE ON DELETE CASCADE;

INSERT INTO "Member"(
            "EmailAddress", "Alias", "Password", "FirstName", "LastName", 
            "DateOfBirth", "ConfirmationId", "DateCreated", "LastVisit", "Token", "SecureId")
VALUES ('fowd-elliot.coad@gmail.com','FOWD','','FOWD','2011','1986-05-04 13:35:41','sdf','2011-05-04 13:35:41.058025','2011-05-04 13:35:41','fowd2011f68556d9594bc210df552c0b85f08d219e93363','u-fowd');

INSERT INTO "Wall"("SecureId", "Description", "Url", "MemberSecureId", "Name")
    VALUES ('gawk', 'Gawk Booth @ The Future of Web Design 2011', 'fowd-2011', 'u-fowd', 'FOWD 2011');
