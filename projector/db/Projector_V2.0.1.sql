
-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : V2.0.1                                      //
-- // Date : 2012-02-11                                     //
-- ///////////////////////////////////////////////////////////
--
--

-- Enable Menus : DocumentType, BillType
UPDATE `${prefix}menu` SET idle=0 where id in (101, 100);

-- Disable Menus : Type (is a goup menu)
UPDATE `${prefix}menu` SET idle=1 where id in (79);

-- Remove habilitations to Disabled sub-Menus : Invoice, Payment, Requestor, InvoiceType,PaymentType, ProjectParameter
UPDATE `${prefix}habilitation` SET allowAccess=0 where idMenu in (77, 78, 12, 82, 83, 19);

-- Delete obsolete menus : Component
DELETE FROM `${prefix}menu` WHERE id in (10); 
DELETE FROM `${prefix}habilitation` WHERE idMenu in (10); 

-- Fix Hierarchic presentation
UPDATE `menu` SET idMenu=0 WHERE id=13;