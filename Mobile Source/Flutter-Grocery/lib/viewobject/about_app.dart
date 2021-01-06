import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';
import 'default_photo.dart';

class AboutApp extends PsObject<AboutApp> {
  AboutApp({
    this.aboutId,
    this.aboutTitle,
    this.aboutDescription,
    this.aboutEmail,
    this.aboutPhone,
    this.aboutWebsite,
    this.adsOn,
    this.adsClient,
    this.adsSlot,
    this.analytOn,
    this.analytTrackId,
    this.facebook,
    this.googlePlus,
    this.instagram,
    this.youtube,
    this.pinterest,
    this.twitter,
    this.privacypolicy,
    this.gdpr,
    this.uploadPoint,
    this.safetyTips,
    this.defaultPhoto,
  });
  String aboutId;
  String aboutTitle;
  String aboutDescription;
  String aboutEmail;
  String aboutPhone;
  String aboutWebsite;
  String adsOn;
  String adsClient;
  String adsSlot;
  String analytOn;
  String analytTrackId;
  String facebook;
  String googlePlus;
  String instagram;
  String youtube;
  String pinterest;
  String twitter;
  String privacypolicy;
  String gdpr;
  String uploadPoint;
  String safetyTips;
  DefaultPhoto defaultPhoto;
  @override
  bool operator ==(dynamic other) =>
      other is AboutApp && aboutId == other.aboutId;

  @override
  int get hashCode => hash2(aboutId.hashCode, aboutId.hashCode);

  @override
  String getPrimaryKey() {
    return aboutId;
  }

  @override
  AboutApp fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return AboutApp(
        aboutId: dynamicData['about_id'],
        aboutTitle: dynamicData['about_title'],
        aboutDescription: dynamicData['about_description'],
        aboutEmail: dynamicData['about_email'],
        aboutPhone: dynamicData['about_phone'],
        aboutWebsite: dynamicData['about_website'],
        adsOn: dynamicData['ads_on'],
        adsClient: dynamicData['ads_client'],
        adsSlot: dynamicData['ads_slot'],
        analytOn: dynamicData['analyt_on'],
        analytTrackId: dynamicData['analyt_track_id'],
        facebook: dynamicData['facebook'],
        googlePlus: dynamicData['google_plus'],
        instagram: dynamicData['instagram'],
        youtube: dynamicData['youtube'],
        pinterest: dynamicData['pinterest'],
        twitter: dynamicData['twitter'],
        privacypolicy: dynamicData['privacypolicy'],
        gdpr: dynamicData['GDPR'],
        uploadPoint: dynamicData['upload_point'],
        safetyTips: dynamicData['safety_tips'],
        defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['about_id'] = object.aboutId;
      data['about_title'] = object.aboutTitle;
      data['about_description'] = object.aboutDescription;
      data['about_email'] = object.aboutEmail;
      data['about_phone'] = object.aboutPhone;
      data['about_website'] = object.aboutWebsite;
      data['ads_on'] = object.adsOn;
      data['ads_client'] = object.adsClient;
      data['ads_slot'] = object.adsSlot;
      data['analyt_on'] = object.analytOn;
      data['analyt_track_id'] = object.analytTrackId;
      data['facebook'] = object.facebook;
      data['google_plus'] = object.googlePlus;
      data['instagram'] = object.instagram;
      data['youtube'] = object.youtube;
      data['pinterest'] = object.pinterest;
      data['twitter'] = object.twitter;
      data['privacypolicy'] = object.privacypolicy;
      data['GDPR'] = object.gdpr;
      data['upload_point'] = object.uploadPoint;
      data['safety_tips'] = object.safetyTips;
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<AboutApp> fromMapList(List<dynamic> dynamicDataList) {
    final List<AboutApp> newFeedList = <AboutApp>[];
    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          newFeedList.add(fromMap(json));
        }
      }
    }
    return newFeedList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
