-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 4.5.6                                       //
-- // Date : 2015-03-06                                     //
-- ///////////////////////////////////////////////////////////

update `${prefix}planningelement` set validatedStartDate=realStartDate, validatedEndDate=realEndDate
WHERE idle=1 and validatedStartDate is null and validatedEndDate is null 
and realStartDate is not null and realEndDate is not null 
and idPlanningMode in (2,3,7);
