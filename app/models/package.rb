class Package < ActiveRecord::Base
  attr_accessible :cnt, :depends, :description, :name, :note, :ver
  has_many :bbs,:dependent => :destroy
  validates :name, :ver, :description,:presence => true
end
