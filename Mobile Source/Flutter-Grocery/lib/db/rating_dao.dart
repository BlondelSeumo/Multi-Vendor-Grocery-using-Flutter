import 'package:fluttermultigrocery/viewobject/rating.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class RatingDao extends PsDao<Rating> {
  RatingDao._() {
    init(Rating());
  }
  static const String STORE_NAME = 'Rating';
  final String _primaryKey = 'id';

  // Singleton instance
  static final RatingDao _singleton = RatingDao._();

  // Singleton accessor
  static RatingDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Rating object) {
    return object.id;
  }

  @override
  Filter getFilter(Rating object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
