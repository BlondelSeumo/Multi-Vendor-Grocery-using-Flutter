import 'package:fluttermultigrocery/viewobject/transaction_detail.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class TransactionDetailDao extends PsDao<TransactionDetail> {
  TransactionDetailDao._() {
    init(TransactionDetail());
  }
  static const String STORE_NAME = 'Transaction';
  final String _primaryKey = 'id';

  // Singleton instance
  static final TransactionDetailDao _singleton = TransactionDetailDao._();

  // Singleton accessor
  static TransactionDetailDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(TransactionDetail object) {
    return object.id;
  }

  @override
  Filter getFilter(TransactionDetail object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
